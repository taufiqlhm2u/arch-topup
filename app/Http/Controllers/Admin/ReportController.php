<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.laporan.index');
    }

    public function cetakLaporan(Request $request)
    {
        $game_id = $request->get('game_id', '');
        $dateStart = $request->get('dateStart', '');
        $dateEnd = $request->get('dateEnd', '');

        $query = Order::with(['package.game'])
            ->where('status', 'successful')
            ->orderBy('created_at', 'desc');

        if ($game_id && $game_id !== 'semua') {
            $query->whereHas('package.game', function ($q) use ($game_id) {
                $q->where('id', $game_id);
            });
        }

        if ($dateStart && $dateEnd) {
            $query->whereBetween('created_at', [$dateStart, $dateEnd]);
        }

        $orders = $query->get();

        $totalPendapatan = $orders->where('status', 'successful')->sum('amount');

        $data = [
            'orders' => $orders,
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd,
            'totalPendapatan' => $totalPendapatan,
            'gameFilter' => $game_id,
        ];

        try {
            $pdf = Pdf::loadView('pages.admin.laporan.cetak', $data);
            return $pdf->download('laporan-order.pdf');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
