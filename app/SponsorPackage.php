<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SponsorPackage extends Model
{   
    public $timestamps = false;
    public function purchases() {
        return $this->belongsToMany('App\Purchase');
    }
}
