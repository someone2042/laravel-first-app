<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rule as ValidationRule;

class ListingController extends Controller
{
    public function index(){
        return view('listings.index',[
            'listings'=> Listing::filter(request(['tag','search']))->simplePaginate(4)
        ]);
    }
    public function show(Listing $listing){
        return view('listings.show',[
            'listing' => $listing
        ]);
    }
    public function create(){
        return view('listings.create');
    }
    public function store(Request $request){
        $formeFieleds= $request->validate([
            'title'=>'required',
            'company'=> ['required', Rule::unique('listings','company')],
            'location'=>'required',
            'website'=>'required',
            'email'=>['required','email'],
            'tags'=>'required',
            'description'=>'required'
        ]);
        Listing::create($formeFieleds);
        return redirect('/')->with('message','Listing created successfully!');
    }
}
