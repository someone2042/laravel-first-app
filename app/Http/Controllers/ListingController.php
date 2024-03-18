<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function index(){
        return view('listings.index',[
            'listings'=> Listing::filter
            (request(['tag','search']))->get()
        ]);
    }
    public function show(Listing $listing){
        return view('listings.show',[
            'listing' => $listing
        ]);
    }
}
