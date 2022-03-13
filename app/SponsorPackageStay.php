<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SponsorPackageStay extends Model
{
    public function stays() {
        return $this->hasMany('App\Stay');
    }

    public function sponsorPackages() {
        return $this->hasMany('App\SponsorPackage');
    }
}
