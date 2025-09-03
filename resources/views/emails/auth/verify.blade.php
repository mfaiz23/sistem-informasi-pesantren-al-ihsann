@component('mail::message')
# Verifikasi Alamat Email Anda

Yth. Calon Santri,

Terima kasih telah melakukan pendaftaran di sistem **PSB Pondok Pesantren Al-Ihsan**.

Untuk melanjutkan, silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda.

@component('mail::button', ['url' => $url])
✔ Verifikasi Alamat Email
@endcomponent

Tautan ini hanya berlaku selama **60 menit**.
Jika Anda tidak merasa membuat akun, abaikan email ini.

Salam hormat,
**Admin PSB Pondok Pesantren Al-Ihsan**
@endcomponent