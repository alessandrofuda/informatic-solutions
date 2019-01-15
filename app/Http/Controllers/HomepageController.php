<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Mail;
use App\Mail\ContactNotification;
use Illuminate\Http\Request;
use App\Traits\CaptchaTrait;


class HomepageController extends Controller
{


    use CaptchaTrait;




    public function index() {

    	return view('homepage');

    }


}
