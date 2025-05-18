<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
    ];

    // 💡 Зв'язок багато-до-багатьох з майстрами
    public function masters()
    {
        return $this->belongsToMany(Master::class);
    }

    // 💬 Відгуки (поліморфний зв'язок)
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}
