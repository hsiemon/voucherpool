<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::orderBy('id', 'desc')->paginate(20);

        return view('offer.index',['offers' => $offers]);
    }

    public function store(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'name' 		=> 'required',
                'discount'  => 'required|numeric',
            ]
        );

        if($validator->passes())
        {   
        	try{
        		$offer= new Offer;
		        $offer->name=$request->get('name');
		        $offer->discount=$request->get('discount');
		        $offer->save();
		        
		        return back()->with('success', 'Offer added successfully');
        	}catch(Exception $e){
        		return back()->with('error', $e->getMessage());
        	}
        }

        return back()->withErrors($validator);
    }
}
