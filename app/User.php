<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Watchinglist;



class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'verified', 'email_token', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['deleted_at'];



    // processo di verifica e-mail in auto-registrazione nuovi utenti
    // Set the verified status to true and make the email token null
    public function verified() {
        $this->verified = 1;
        $this->email_token = null;

        $this->save();
    }



    /** relations*/
    public function posts() {
      return $this->hasMany('App\Post','author_id');
    }

    public function comments() {
      return $this->hasMany('App\Comment','from_user');
    }



    /** user roles*/
    public function is_admin() {
        
      $role = $this->role;
      if($role == 'admin') {
        return true;
      }

      return false;

    }


    public function is_author() {

        $role = $this->role;
        if($role == 'author') {
            return true;
        }

        return false;
    }


    public function is_subscriber() {
        
          $role = $this->role;
          if($role == 'subscriber') {
            return true;
          }

          return false;

    }


    /*l'utente è in watchinglist ? */
    public function isInWatchinglist($product_id) {

        $items = Watchinglist::where('user_id', $this->attributes['id'] )->where('product_id', $product_id)->get();

        if (count($items) <= 0) {
            return false;
        }

        return true;
    }



}
