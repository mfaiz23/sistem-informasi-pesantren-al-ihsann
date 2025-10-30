<?php

namespace App\Models;

use App\Traits\LogsChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParentData extends Model
{
    use HasFactory, LogsChanges;

    protected $table = 'parents';

    protected $fillable = [
        'formulir_id',
        'nama_lengkap',
        'no_telp',
        'alamat',
        'hubungan_keluarga',
    ];

    /**
     * Mendapatkan formulir yang memiliki data orang tua ini.
     */
    public function formulir(): BelongsTo
    {
        return $this->belongsTo(Formulir::class);
    }
}
