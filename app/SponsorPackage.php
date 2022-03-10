<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SponsorPackage extends Model
{   
    public $timestamps = false;
    public function stays() {
        return $this->belongsToMany('App\Stay')->withPivot('start_date', 'end_date')->withTimestamps();
    }
}
