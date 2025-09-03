<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulirLog extends Model
{
    use HasFactory;

    // Tabel ini tidak menggunakan created_at/updated_at bawaan
    public $timestamps = false;

    protected $fillable = [
        'formulir_id',
        'user_id',
        'field_name',
        'old_value',
        'new_value',
        'edited_at',
    ];

    protected $casts = [
        'edited_at' => 'datetime',
    ];
}
