<x-mail::message>
# Pemberitahuan Penolakan Formulir Pendaftaran

Yth. Bapak/Ibu **{{ $formulir->user->name }}**,

Dengan berat hati kami memberitahukan bahwa formulir pendaftaran atas nama **{{ $formulir->nama_lengkap ?? $formulir->user->name }}** telah kami tinjau dan saat ini belum dapat kami terima.

**Alasan Penolakan:**
<x-mail::panel>
{{ $formulir->alasan_penolakan }}
</x-mail::panel>

Namun, Anda tidak perlu khawatir. Anda dapat memperbaiki formulir pendaftaran Anda sesuai dengan alasan yang kami sebutkan di atas dengan menekan tombol di bawah ini.

<x-mail::button :url="route('dashboard')">
Perbaiki Formulir
</x-mail::button>

Setelah Anda memperbaiki dan mengirimkan kembali formulir tersebut, kami akan segera meninjaunya kembali.

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
