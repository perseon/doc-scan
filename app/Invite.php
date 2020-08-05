<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    //
    protected $guarded = [];

    public function Applications(){

        return $this->hasMany('App\Application');
    }
}
