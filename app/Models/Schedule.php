<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'day',
        'start_hours',
        'start_minutes',
        'end_hours',
        'end_minutes'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }


    public function getStartHoursMinutes() 
    {
        $hours = $this->start_hours;
        if (strlen($hours) === 1) {
            $hours = '0' . $hours;
        }

        $minutes = $this->start_minutes;
        if (strlen($minutes) === 1) {
            $minutes = '0' . $minutes;
        }

        return $hours . ":" . $minutes;
    }

    public function getEndHoursMinutes() 
    {
        $hours = $this->end_hours;
        if (strlen($hours) === 1) {
            $hours = '0' . $hours;
        }

        $minutes = $this->end_minutes;
        if (strlen($minutes) === 1) {
            $minutes = '0' . $minutes;
        }

        return $hours . ":" . $minutes;
    }
}
