<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adress extends Model
{
    protected $fillable = ['country_id', 'city_id', 'street_id'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function street()
    {
        return $this->belongsTo(Street::class);
    }
}
