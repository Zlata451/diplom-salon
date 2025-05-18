<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'rating',
        'comment',
        'reviewable_id',
        'reviewable_type',
    ];

    /**
     * 🔗 Автор відгуку
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 📌 Зв'язок з послугою або майстром (поліморфний)
     */
    public function reviewable()
    {
        return $this->morphTo();
    }
}
