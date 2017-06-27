<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use App\User;



class Pricenotification extends Model
{


	public static function isInTodayPricenotificationList($user_id) {

		$today_notification = Pricenotification::where('user_id', $user_id)
												->whereRaw('date(created_at) = ?', [Carbon::today()])
												->get();

		if ( count($today_notification) > 0 ) {
			return true;
		} else {
			return false;
		}

	}



	public static function insertInPricenotificationList($user_id) {

		$new = new Pricenotification;
		$new->user_id = $user_id;

		$new->save();

		return;

	}



	public static function cleanOldPricenotificationList() {  
		
		$deletedRows = Pricenotification::whereRaw('date(created_at) < ?', [Carbon::now()->subMonth()])->delete();  
		
		return;

	}



	/*relazioni*/
    public function user() {
		return $this->belongsTo(User::class);
	}


}
