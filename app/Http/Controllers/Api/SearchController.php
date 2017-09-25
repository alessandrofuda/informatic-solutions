<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;


class SearchController extends Controller
{
    public function search(Request $request)
    {
    	// First we define the error message we are going to show if no keywords
        // existed or if no results found.
        $error = ['error' => 'Nessun risultato trovato, prova con altre ricerche.'];

        // Making sure the user entered a keyword.
        if($request->has('q')) {

            // Using the Laravel Scout syntax to search the products table.
            $posts = Product::search($request->get('q'))->get();

            // If there are results return them, if none, return the error message.
            return $posts->count() ? $posts : $error;

        }

        // Return the error message if no keywords existed
        return $error;
    }

}
