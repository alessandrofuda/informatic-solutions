<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Watchinglist;


class Product extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $fillable = ['id','json','asin','........'];


    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    /*relazioni*/
    public function watchinglist() {
        return $this->hasMany(Watchinglist::class);
    }


    /*custom function*/

}
