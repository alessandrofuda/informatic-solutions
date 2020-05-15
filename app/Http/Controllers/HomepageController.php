<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Mail;
use App\Mail\ContactNotification;
use Illuminate\Http\Request;
use App\Traits\CaptchaTrait;


class HomepageController extends Controller {

    use CaptchaTrait;

    public function __construct() {
    	$this->page_type = 'homepage';
    	$this->slug = 'homepage';
    }


    public function index() {
    	return view('homepage', ['page_type' => $this->page_type, 'slug' => $this->slug]);
    }


}
