<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Product;
use App\User;


class Watchinglist extends Model
{
    
	protected $fillable = ['user_id', 'product_id'];



    //relazioni
	public function product() {
		return $this->belongsTo(Product::class);  // many ????
	}

	public function user() {
		return $this->belongsTo(User::class);
	}
    
    
}
