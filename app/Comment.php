<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    // comments table in database
    protected $guarded = [];
    protected $dates = ['deleted_at'];   //aggiunto per utilizzare la funzione softDeletes();


    // ogni Comment appartiene a UN User
    // user who has commented
    public function author(){
      return $this->belongsTo('App\User','from_user'); //from_user è la foreign key, sarebbe lo user_id, in Comment
    }


    // ogni Comment appartiene a UN Post
    // returns post of any comment
    public function post(){
      return $this->belongsTo('App\Post','on_post');  //on_post è una foreign key in Comment
    }
    
}
