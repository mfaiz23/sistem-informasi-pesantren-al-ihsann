<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentData extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     *
     * @var string
     */
    protected $table = 'parents'; // <-- TAMBAHKAN BARIS INI

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'formulir_id', 'nama_ayah', 'no_telp_ayah',
        'nama_ibu', 'no_telp_ibu',
        'nama_wali', 'no_telp_wali',
    ];
}
