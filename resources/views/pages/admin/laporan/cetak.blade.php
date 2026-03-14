<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .info {
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total {
            margin-top: 20px;
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Order</h2>
        @if($dateStart && $dateEnd)
            <p>Periode: {{ \Carbon\Carbon::parse($dateStart)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($dateEnd)->translatedFormat('d F Y') }}</p>
        @else
            <p>Periode: Semua Data</p>
        @endif
    </div>

    <div class="info">
        <p><strong>Total Pendapatan (Sukses):</strong> Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Order</th>
                <th>Game</th>
                <th>Paket</th>
                <th>Player ID</th>
                <th>Email</th>
                <th class="text-center">Jumlah</th>
                <th class="text-right">Bayar</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $index => $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->no_kw }}</td>
                <td>{{ $order->package->game->name ?? '-' }}</td>
                <td>{{ $order->package->quantity . ' ' . $order->package->type }}</td>
                <td>{{ $order->server_id ? $order->player_id . ' (' . $order->server_id . ')' : $order->player_id }}</td>
                <td>{{ $order->email }}</td>
                <td class="text-center">{{ $order->qty }}</td>
                <td class="text-right">Rp {{ number_format($order->amount, 0, ',', '.') }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>{{ $order->created_at->translatedFormat('d F Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="total">
        Total Baris: {{ $orders->count() }}
    </div>
</body>
</html>