<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    protected $fillable = ['name'];

    public function Adress()
    {
        return $this->hasOne(Adress::class);
    }
}
