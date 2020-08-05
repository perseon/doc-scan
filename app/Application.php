<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    //
    protected $guarded = [];

    public function Invites() {
        return $this->belongsTo('App\Invite');
    }
}
