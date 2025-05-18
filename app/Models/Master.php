<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Master extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'specialty',
        'phone',
        'email',
        'photo',
    ];

    /**
     * 💇‍♀️ Багато-до-багатьох — Майстер надає декілька послуг
     */
    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    /**
     * ⏰ Один-до-багатьох — Графік роботи майстра
     */
    public function workingHours()
    {
        return $this->hasMany(WorkingHour::class);
    }

    /**
     * 💬 Відгуки (поліморфний зв'язок)
     */
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}
