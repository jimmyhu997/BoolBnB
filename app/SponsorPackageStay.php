<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SponsorPackageStay extends Model
{   
    public $table = 'sponsor_package_stay';
    
    public function stays() {
        return $this->hasMany('App\Stay');
    }

    public function sponsorPackages() {
        return $this->hasMany('App\SponsorPackage');
    }
}
