<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['firstname', 'lastname', 'adress_id'];


    public function adress()
    {
        return $this->belongsTo(Adress::class);
    }

    public function scopeGetUser($query, $firstname, $lastname)
    {
        return $query->where('firstname', $firstname)->where('lastname', $lastname)->get();
    }
}
