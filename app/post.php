<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    //

    public function user(){
       return $this->belongsTo('App/user');
    }
    public function doctor(){
      return   $this->belongsTo('App/doctor');
    }
}
