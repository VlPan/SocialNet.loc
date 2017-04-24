<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //define relations in our model file
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function likes(){
        return $this->hasMany('App\Like');
    }
}
