<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkingHour extends Model
{
    protected $fillable = ['master_id', 'day_of_week', 'start_time', 'end_time'];

    public function master()
    {
        return $this->belongsTo(Master::class);
    }
}
