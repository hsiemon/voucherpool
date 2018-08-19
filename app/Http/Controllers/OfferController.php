<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;

/**
*   OfferController
*
*   Controller to manage requests related with the Offers
*
*   @author Henrique Siemon <henriquesiemon@msn.com>
*/
class OfferController extends Controller
{
    /**
    *   Index action to show a list of offers
    */ 
    public function index()
    {
        //Get all offers paginated by 20 records
        $offers = Offer::orderBy('id', 'desc')->paginate(20);

        return view('offer.index',['offers' => $offers]);
    }

    /**
    *   Store action to insert an offer in the database
    *
    *   @param $request Request Request data
    */ 
    public function store(Request $request)
    {
        //Set the validator rules
        $validator = \Validator::make(
            $request->all(),
            [
                'name' 		=> 'required',
                'discount'  => 'required|numeric',
            ]
        );

        //Validate the request
        if($validator->passes())
        {   
        	try{
                //Creates the offer an insert on the database
        		$offer= new Offer;
		        $offer->name=$request->get('name');
		        $offer->discount=$request->get('discount');
		        $offer->save();
		        
                //Return with an success message
		        return back()->with('success', 'Offer added successfully');
        	}catch(Exception $e){
                //Return with an error message
        		return back()->with('error', $e->getMessage());
        	}
        }

        //Return with the validator errors
        return back()->withErrors($validator);
    }
}
