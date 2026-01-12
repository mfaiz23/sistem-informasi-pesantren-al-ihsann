<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $table = 'faq';

    protected $fillable = [
        'pertanyaan',
        'jawaban',
        'faq_topic_id',
        'users_id',
    ];

    /**
     * Relasi Many-to-One ke model FaqTopic (inverse).
     * Satu FAQ hanya dimiliki oleh satu Topik.
     */
    public function topic()
    {
        return $this->belongsTo(FaqTopic::class, 'faq_topic_id');
    }

    /**
     * Relasi ke user (admin) yang membuat FAQ.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
