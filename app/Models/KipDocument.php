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
        'status_verifikasi',
    ];
}
