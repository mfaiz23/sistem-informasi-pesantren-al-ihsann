<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    */

    'accepted' => 'Kolom :attribute harus diterima.',
    'current_password' => 'Kata sandi yang diberikan tidak cocok dengan kata sandi Anda saat ini.',
    'date' => 'Kolom :attribute bukan tanggal yang valid.',
    'date_format' => 'Kolom :attribute tidak cocok dengan format :format.',
    'email' => 'Kolom :attribute harus berupa alamat email yang valid.',
    'file' => 'Kolom :attribute harus berupa file.',
    'in' => 'Kolom :attribute yang dipilih tidak valid.',
    'max' => [
        'numeric' => 'Kolom :attribute tidak boleh lebih dari :max.',
        'file' => 'Kolom :attribute tidak boleh lebih dari :max kilobita.',
        'string' => 'Kolom :attribute tidak boleh lebih dari :max karakter.',
        'array' => 'Kolom :attribute tidak boleh memiliki lebih dari :max item.',
    ],
    'mimes' => 'Kolom :attribute harus berupa file dengan tipe: :values.',
    'nullable' => 'Kolom :attribute boleh kosong.',
    'required' => 'Kolom :attribute wajib diisi.',
    'required_if' => 'Kolom :attribute wajib diisi bila :other adalah :value.',
    'size' => [
        'numeric' => 'Kolom :attribute harus berukuran :size.',
        'file' => 'Kolom :attribute harus berukuran :size kilobita.',
        'string' => 'Kolom :attribute harus berukuran :size karakter.',
        'array' => 'Kolom :attribute harus mengandung :size item.',
    ],
    'string' => 'Kolom :attribute harus berupa string.',
    'unique' => ':attribute ini sudah terdaftar.',
    'uploaded' => 'Kolom :attribute gagal diunggah.',

    'numeric' => 'Kolom :attribute harus berupa angka.',
    'min' => [
        'numeric' => 'Kolom :attribute harus minimal :min.',
        'string' => 'Kolom :attribute harus memiliki minimal :min karakter.',
    ],
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'regex' => 'Format :attribute tidak valid.',
    'digits_between' => ':attribute harus memiliki antara :min dan :max digit.',

    // ===== TAMBAHAN YANG DIPERLUKAN DI SINI =====
    'digits' => 'Kolom :attribute harus terdiri dari :digits digit.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        'name' => 'Nama Lengkap',
        'no_telp' => 'No. Handphone',
        'password' => 'Kata Sandi',
        'nama_panggilan' => 'Nama Panggilan',
        'tempat_lahir' => 'Tempat Lahir',
        'tanggal_lahir' => 'Tanggal Lahir',
        'jenis_kelamin' => 'Jenis Kelamin',
        'nik' => 'NIK',
        'kategori_pendaftaran' => 'Kategori Pendaftaran',
        'no_kip' => 'No. KIP',
        'dokumen_kip' => 'Dokumen KIP',
        'asal_sd' => 'Asal SD/MI',
        'tahun_lulus_sd' => 'Tahun Lulus SD/MI',
        'asal_smp' => 'Asal SMP/MTs',
        'tahun_lulus_smp' => 'Tahun Lulus SMP/MTs',
        'asal_sma' => 'Asal SMA/SMK/MA',
        'tahun_lulus_sma' => 'Tahun Lulus SMA/SMK/MA',
        'asal_universitas' => 'Universitas',
        'jurusan' => 'Jurusan',
        'fakultas' => 'Fakultas',
        'semester' => 'Semester',
        'angkatan' => 'Angkatan',
        'negara' => 'Negara',
        'provinsi' => 'Provinsi',
        'kota_kabupaten' => 'Kota/Kabupaten',
        'kecamatan' => 'Kecamatan',
        'desa_kelurahan' => 'Desa/Kelurahan',
        'alamat_lengkap' => 'Alamat Lengkap',
        'nama_lengkap' => 'Nama Lengkap Orang Tua',
        'alamat' => 'Alamat Orang Tua',
        'hubungan_keluarga' => 'Hubungan Keluarga',
    ],

];
