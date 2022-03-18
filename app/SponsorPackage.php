<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SponsorPackage extends Model
{   
    public $timestamps = false;
    public function sponsorPackageStays() {
        return $this->belongsToMany('App\SponsorPackageStay');
    }
}
