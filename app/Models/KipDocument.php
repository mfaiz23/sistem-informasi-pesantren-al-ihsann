<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KipDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'formulir_id',
        'dokumen_path',
        'no_kip',
        'status_verifikasi',
    ];
}
