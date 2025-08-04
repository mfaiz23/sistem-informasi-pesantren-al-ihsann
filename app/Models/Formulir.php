<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulir extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'tempat_lahir',
        'tanggal_lahir',
        'asal_sekolah',
        'kategori_pendaftaran',
        'no_ijazah',
        'no_telp_orang_tua',
    ];
}
