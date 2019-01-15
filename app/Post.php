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
      return $this->hasMany('App\Comment','on_post');  // 'on_post' è la chiave esterna sta al posto del 'post_id' (che è il valore di default)
    }


    // ogni Post appartiene a un User
    // returns the instance of the user who is author of that post
    public function author(){
      return $this->belongsTo('App\User','author_id'); // author_id è la foreign key nella tabella posts (che lo collega alla tabella users)
    }



}
