<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

class Company extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;

    protected $softCascade = ['services', 'schedules'];

    protected $fillable = [
        'user_id',
        'name',
        'city',
        'address',
        'image',
        'description',
        'active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function reservations()
    {
        return $this->hasManyThrough(Reservation::class, Service::class);
    }
}
