<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;
    protected $fillable = ['first_name', 'second_name', 'email', 'gender', 'city', 'country', 'status'];

    public function posts()
    {
        return $this->hasMany('App\Post');//Relations!!
    }

    public function likes()
    {
        return $this->hasMany('App\Like'); //Relations!!
    }

    public function friends()
    {
        return $this->hasMany('App\Friend'); //Relations!!
    }


    public function messages()
    {
        return $this->hasMany('App\Message'); //Relations!!
    }
}
