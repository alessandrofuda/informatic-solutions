<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;

class UsersController extends Controller {
    
	public function deleteOldUnverifiedUsers() {

		$month_ago = Carbon::now()->subMonth();

		try {

			return User::where('verified', User::NOT_VERIFIED)->whereDate('created_at','<', $month_ago)->forceDelete();	

		} catch (Exception $e) {
			Log::error('Error during Not verified users cancellation: '.$e->getMessage());
		}
	}
}
