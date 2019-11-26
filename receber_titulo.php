<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class receber_titulo extends Model
{
    public function usuario(){
    	   return $this->hasMany('App\usuario');
    }
}
