@component('mail::message')
# Konfirmasi Pembayaran Berhasil

**Assalamualaikum Wr. Wb. {{ $invoice->user->name }},**

Alhamdulillah, kami telah menerima pembayaran biaya formulir pendaftaran Anda.

Berikut adalah rincian transaksi Anda:

@component('mail::panel')
- **Nomor Invoice:** {{ $invoice->invoice_number }}
- **Jumlah Pembayaran:** Rp {{ number_format($invoice->amount, 0, ',', '.') }}
- **Tanggal Bayar:** {{ $invoice->completed_at->format('d F Y, Pukul H:i') }} WIB
@endcomponent

Jika Anda memiliki pertanyaan atau mengalami kendala, jangan ragu untuk menghubungi kami.

Terima kasih,
**Admin PSB {{ config('app.name') }}**
@endcomponent