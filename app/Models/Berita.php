<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'berita';

    // Kolom yang boleh diisi saat membuat atau mengupdate data
    protected $fillable = [
        'users_id',
        'judul',
        'isi',
        'gambar',
        'status',
        'published_at',
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
