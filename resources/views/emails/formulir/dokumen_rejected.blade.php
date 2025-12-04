<!DOCTYPE html>
<html>
<head>
    <title>Dokumen Ditolak</title>
</head>
<body>
    <h3>Halo, {{ $user->name }}</h3>
    <p>Mohon maaf, dokumen <strong>{{ $namaDokumen }}</strong> yang Anda unggah berstatus <strong>DITOLAK</strong>.</p>

    <p><strong>Alasan Penolakan:</strong><br>
    {{ $alasan }}</p>

    <p>Mohon segera login ke dashboard dan unggah ulang dokumen yang sesuai agar proses verifikasi pendaftaran dapat dilanjutkan.</p>

    <p>Terima kasih,<br>Panitia Pendaftaran</p>
</body>
</html>
