<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    public function stay() {
        return $this->belongsTo('App\Stay');
    }
}
