<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FaqTopic extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    /**
     * Relasi One-to-Many ke model Faq.
     * Satu topik bisa memiliki banyak FAQ.
     */
    public function faqs()
    {
        return $this->hasMany(Faq::class, 'faq_topic_id');
    }

    /**
     * Otomatis membuat slug saat membuat atau mengubah nama topik.
     */
    protected static function boot()
    {
        parent::boot();
        static::saving(function ($topic) {
            $topic->slug = Str::slug($topic->name, '-');
        });
    }
}
