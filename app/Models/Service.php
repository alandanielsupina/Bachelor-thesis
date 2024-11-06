<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

class Service extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;

    protected $softCascade = ['reservations'];

    protected $fillable = [
        'company_id',
        'name',
        'price',
        'length'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
