<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'service_id',
        'user_id',
        'start_at',
        'end_at',
        'cancelled_at',
        'cancelled_by_company',
        'reason_for_cancellation'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUserName() 
    {
        return User::find($this->user_id)->name;
    }

    public function getServiceName() 
    {
        return Service::find($this->service_id)->name;
    }
}
