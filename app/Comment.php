<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model {
    use SoftDeletes;

    const TYPE = [
        'PARENT' => 0,
        'CHILD' => 1
    ];
    const STATUS = [
        'APPROVED' => 1,
        'PENDING' => 0
    ];

    protected $guarded = [];
    protected $dates = ['deleted_at']; 

    public function author(){
      return $this->belongsTo('App\User','from_user'); //from_user: foreign key
    }

    public function post(){
      return $this->belongsTo('App\Post','on_post');  //on_post: fk
    }

    public function scopeParent($query) {
        return $query->where('comment_parent', self::TYPE['PARENT']);
    }
    
    public function scopeChild($query) {
        return $query->where('comment_parent', '>', 0); 
    }

    public function scopeApproved($query) {
        return $query->where('comment_approved', self::STATUS['APPROVED']);
    }

    public function scopePending($query) {
        return $query->where('comment_approved', self::STATUS['PENDING']);
    }
    
}
