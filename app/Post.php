<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // restricts columns from modifying
    protected $guarded = [];


    // relationships

    // ogni Post ha molti Comments
    // returns all comments on that post
    public function comments(){
      return $this->hasMany('App\Comment','on_post'); 
    }


    // ogni Post appartiene a un User
    // returns the instance of the user who is author of that post
    public function author(){
      return $this->belongsTo('App\User','author_id'); 
    }



}
