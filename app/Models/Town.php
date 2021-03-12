<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function town()
    {
        return $this->belongsTo(Town::class);
    }

    public function getCreatedAtAttribute($date)
    {
        $time = new DateTime($date);
        return $time->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($date)
    {
        $time = new DateTime($date);
        return $time->format('Y-m-d H:i:s');
    }
}
