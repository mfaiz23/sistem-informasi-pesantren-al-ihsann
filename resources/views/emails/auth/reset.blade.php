@component('mail::message')
# Permintaan Pengaturan Ulang Kata Sandi

**Yth. Calon Santri,**

Anda menerima email ini karena kami menerima permintaan pengaturan ulang kata sandi untuk akun Anda.

Silakan klik tombol di bawah ini untuk membuat kata sandi baru.
Tautan ini akan kedaluwarsa dalam **60 menit**.

@component('mail::button', ['url' => $url])
Atur Ulang Kata Sandi
@endcomponent

Jika Anda tidak merasa meminta pengaturan ulang kata sandi, harap abaikan email ini.

Hormat kami,
**Admin PSB {{ config('app.name') }}**
@endcomponent