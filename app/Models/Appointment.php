<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'master_id',
        'date',
        'time',
        'status',
    ];

    // Связь с клиентом
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Связь с услугой
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Связь с мастером
    public function master()
    {
        return $this->belongsTo(Master::class);
    }
}
