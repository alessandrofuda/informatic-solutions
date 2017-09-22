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


    /*custom functions*/
    public static function italian_date($mysql_date)
    {
        $d = explode(' ', $mysql_date);
        $h = explode(':', $d[1]);
        $h = $h[0].':'.$h[1];
        $d = explode('-', $d[0]);
        $d = $d[2].'/'.$d[1].'/'.$d[0]; 

        $italian_date = $d.' - '.$h;

        return $italian_date;
    }

}
