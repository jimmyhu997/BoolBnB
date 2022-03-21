<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{   
    
    public function stay() {
        return $this->hasOne('App\Stay');
    }

    public function sponsorPackage() {
        return $this->hasOne('App\SponsorPackage');
    }
}
