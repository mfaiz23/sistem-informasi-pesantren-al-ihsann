<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * @var array
     */
    protected $casts = [
        'due_date' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Setiap invoice dimiliki oleh satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Setiap invoice bisa memiliki satu record Payment.
     * (Relasi ini opsional tergantung kebutuhan detail pembayaran).
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
