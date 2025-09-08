<?php

namespace App\Models;

use App\Traits\LogsChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Formulir extends Model
{
    use HasFactory, LogsChanges;

    protected $fillable = [
        'user_id', 'nama_panggilan', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'nik',
        'kategori_pendaftaran',
        'no_kip',
        'asal_sd', 'tahun_lulus_sd', 'asal_smp', 'tahun_lulus_smp',
        'asal_sma', 'tahun_lulus_sma', 'asal_universitas', 'jurusan', 'fakultas',
        'semester', 'angkatan', 'status_pendaftaran',
    ];

    /**
     * Menetapkan nilai default untuk atribut model.
     * Setiap record Formulir baru akan otomatis memiliki status ini.
     * INI ADALAH PENAMBAHANNYA.
     *
     * @var array
     */
    protected $attributes = [
        'status_pendaftaran' => 'menunggu_verifikasi',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // Relasi ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function alamat(): HasOne
    {
        return $this->hasOne(Alamat::class);
    }

    public function parent(): HasOne
    {
        return $this->hasOne(ParentData::class);
    }

    // Tambahkan relasi ke KipDocument
    public function kipDocument(): HasOne
    {
        return $this->hasOne(KipDocument::class);
    }
}
