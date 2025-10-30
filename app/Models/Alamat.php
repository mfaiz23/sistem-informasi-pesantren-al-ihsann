<?php

namespace App\Models;

use App\Traits\LogsChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alamat extends Model
{
    use HasFactory, LogsChanges;

    protected $table = 'alamat';

    protected $fillable = [
        'formulir_id',
        'negara',
        'provinsi',
        'kota_kabupaten',
        'kecamatan',
        'desa_kelurahan',
        'alamat_lengkap',
    ];

    /**
     * Mendapatkan formulir yang memiliki alamat ini.
     */
    public function formulir(): BelongsTo
    {
        return $this->belongsTo(Formulir::class);
    }
}
