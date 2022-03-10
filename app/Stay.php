<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stay extends Model
{
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function visits() {
        return $this->hasMany('App\Visit');
    }

    public function messages() {
        return $this->hasMany('App\Message');
    }
    
    public function perks() {
        return $this->belongsToMany('App\Perk');
    }
    
    public function sponsorPackages() {
        return $this->belongsToMany('App\SponsorPackage')->withPivot('start_date', 'end_date')->withTimestamps();
    }




}
