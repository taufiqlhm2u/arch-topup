<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Package;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Str;

class OrderController extends Controller
{

    protected $flipBaseUrl;
    protected $flipApiKey;
    public function __construct()
    {
        $this->flipBaseUrl = config('services.flip.baseUrl', env('FLIP_BASE_URL'));
        $this->flipApiKey = config('services.flip.api_key', env('FLIP_API_KEY'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required',
            'player_id' => 'required|string|max:50',
            'server_id' => 'nullable|string|max:50',
            'qty' => 'required|integer|min:1',
            'email' => 'required|email',
        ]);

        try {
            // Cek paket
            $package = Package::findOrFail($validated['package_id']);
            $totalAmount = $package->price * $validated['qty'];

            // order ke database
            $order = Order::create([
                'package_id' => $validated['package_id'],
                'no_kw' => 'KW-' . time() . Str::random(3) . uniqid(),
                'player_id' => $validated['player_id'],
                'server_id' => $request->server_id ? $request->server_id : null,
                'qty' => $validated['qty'],
                'email' => $validated['email'],
                'amount' => $totalAmount,
                'external_id' => null,
                'payment_url' => null,
                'status' => 'pending',
            ]);

            $user = $request->server_id ? $validated['player_id'] . ' (' . $validated['server_id'] . ')' : $validated['player_id'];

            $description = "Pembayaran untuk paket " . $package->type . ' ' . $package->game->name . " sejumlah " . $validated['qty'] . " unit" . ' untuk ' . $user;

            $payload = [
                'title' => $description,
                'amount' => (int) $totalAmount,
                'type' => 'SINGLE',
                'expired_date' => now()->addHours(24)->format('Y-m-d H:i'),
                'redirect_url' => config('app.ngrok') . '/finished/payment/' . $order->no_kw,
                'status' => 'ACTIVE',
            ];

            // kirim ke flip
            $response = Http::withBasicAuth($this->flipApiKey, '')
                ->withHeader('Accept', 'application/json')
                ->post($this->flipBaseUrl, $payload);

            if ($response->successful()) {
                $data = json_decode($response);
                $order->update([
                    'payment_url' => $data->link_url,
                    'external_id' => $data->link_id
                ]);

                $log = response()->json([
                    'message' => 'Pesanan Berhasil Dibuat',
                    'data' => [
                        'order' => $order,
                        'payment_url' => $order->payment_url,
                    ],
                ], 201);

                Log::info('Order Created: \n ' . $log);

                return redirect()->away('https://' . $data->link_url);
                
            } else {
                Log::error('Flip API Error: ', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                $order->update(['status' => 'failed']);

                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat bill di Flip.',
                    'error' => $response->json() ?? $response->body()
                ], $response->status());
            }
        } catch (Exception $e) {
            Log::error('Exception saat membuat order: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan internal server.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    // untuk flip 
   public function notification(Request $request)
{
    try {
        // Log raw request untuk debugging
        Log::info('Flip webhook received', $request->all());

        $response = $request->all();

        // Pastikan field 'data' ada
        if (!isset($response['data'])) {
            Log::warning('Field data tidak ditemukan dalam request', $response);
            return response()->json(['message' => 'Data tidak lengkap'], 422);
        }

        // Decode JSON string menjadi array
        $payload = json_decode($response['data'], true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($payload)) {
            Log::error('Gagal decode JSON data', ['data' => $response['data']]);
            return response()->json(['message' => 'Invalid JSON format'], 422);
        }

        // Ambil external_id dan status dari payload hasil decode
        $externalId = $payload['bill_link_id'] ?? $payload['link_id'] ?? null;
        $flipStatus = $payload['status'] ?? null;

        if (!$externalId || !$flipStatus) {
            Log::warning('Data tidak lengkap dalam payload', $payload);
            return response()->json(['message' => 'Data tidak lengkap'], 422);
        }

        // Cari order berdasarkan external_id
        $order = Order::where('external_id', $externalId)->first();

        if (!$order) {
            Log::error('Order tidak ditemukan untuk external_id: ' . $externalId);
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Mapping status Flip ke status internal
        switch (strtoupper($flipStatus)) {
            case 'PAID':
            case 'SUCCESS':
            case 'COMPLETED':
            case 'SUCCESSFUL': // Tambahkan ini karena di log status = SUCCESSFUL
                $order->status = 'successful';
                break;
            case 'FAILED':
            case 'EXPIRED':
                $order->status = 'failed';
                break;
            default:
                $order->status = 'pending';
        }

        $order->save();

        return response()->json(['message' => 'sukses']);
    } catch (Exception $e) {
        Log::error('Exception saat update order: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan internal server.',
        ], 500);
    }
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
