<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        h1 { text-align: center; margin-bottom: 5px; }
        .date { text-align: center; font-size: 12px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 12px; }
        th { background-color: #f2f2f2; }
        .total { font-weight: bold; }
        .paid { color: green; }
        .pending { color: orange; }
        .failed, .expired { color: red; }
    </style>
</head>
<body>

    <h1>Laporan Keuangan</h1>
    <p class="date">Dicetak pada: {{ $tanggalCetak }}</p>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>No. Invoice</th>
                <th>Nama Lengkap</th>
                <th>Tanggal Pembayaran</th>
                <th>Status</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @php $totalAmount = 0; @endphp
            @forelse($invoices as $index => $invoice)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->user->name ?? 'N/A' }}</td>
                    <td>{{ $invoice->completed_at ? $invoice->completed_at->format('d/m/Y') : '-' }}</td>
                    <td class="capitalize {{ $invoice->status }}">{{ $invoice->status }}</td>
                    <td>Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
                </tr>
                @php
                    if ($invoice->status == 'paid') {
                        $totalAmount += $invoice->amount;
                    }
                @endphp
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data yang cocok dengan filter.</td>
                </tr>
            @endforelse
            <tr class="total">
                <td colspan="5" style="text-align: right;">Total Pemasukan (Lunas)</td>
                <td>Rp {{ number_format($totalAmount, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

</body>
</html>
