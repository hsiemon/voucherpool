<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\Recipient;
use App\Models\Offer;

/**
*   VoucherController
*
*   Controller to manage requests related with the Vouchers
*
*   @author Henrique Siemon <henriquesiemon@msn.com>
*/
class VoucherController extends Controller
{
    /**
    *   Index action to show a list of vouchers
    */ 
    public function index()
    {
        //Get all vouchers paginated by 20 records
        $vouchers = Voucher::orderBy('id', 'desc')->paginate(20);

        //Get all offers to the offer_id select
        $offers = Offer::all();

        return view('voucher.index',['vouchers' => $vouchers, 'offers' => $offers]);
    }

    /**
    *   Generates vouchers to all recipients using an offer_id and a expiration date
    *
    *   @param $request Request Request data
    */ 
    public function generate(Request $request)
    {
        //Set the validator rules
        $validator = \Validator::make(
            $request->all(),
            [
                'offer_id' => 'required',
                'expiration'  => 'required|date_format:"Y/m/d H:i"',
            ]
        );

        //Validate the request
        if($validator->passes())
        {
            try{
                //Get the offer from the database
                $offer = Offer::findOrFail($request->offer_id);

                //Get all recipients
                $recipients = Recipient::all();
                
                //Foreach recipient, generate an offer
                foreach($recipients as $recipient){

                    //Creates the offer, set the values and insert
                    $voucher = factory(Voucher::class)->make();
                    $voucher->offer_id = $offer->id;
                    $voucher->recipient_id = $recipient->id;
                    $voucher->expiration = str_replace('/', '-', $request->expiration);
                    $voucher->generateCode($recipient->email, $offer->id, $voucher->expiration)
                            ->save();
                }

                //Return with an success message
                return back()->with('success', 'Vouchers generated successfully');
            }catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
                //Return with an error message
                return back()->with('error', 'Offer not found');
            }
        }

        //Return with the validator errors
        return back()->withErrors($validator);
    }

    /**
    *   Validates and redeem a voucher
    *
    *   @param $request Request Request data
    */ 
    public function redeem(Request $request)
    {
        //Set the validator rules
        $validator = \Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'code'  => 'required',
            ]
        );

        //Validate the request
        if($validator->passes())
        {   
            //Get the recipient
            $recipient = Recipient::where(['email' => $request->email])->first();

            //If the recipient and the voucher exists...
            if($recipient && 
                $verifiedVoucher = Voucher::where('recipient_id', $recipient->id)
                ->where('code', $request->code)
                ->first()){

                //Check if the voucher is valid
                $isVoucherValid = $verifiedVoucher->validate();

                //If the voucher is valid and not used...
                if($isVoucherValid['valid']===true && empty($verifiedVoucher->usedAt)){
                    //Sets the date of usage and save
                    $verifiedVoucher->usedAt = date('Y-m-d H:i:s');
                    $verifiedVoucher->alreadyUsed = true;
                    $verifiedVoucher->save();

                    //Return with an success message
                    return back()->with('success', 'Voucher redeemed successfully, '.$verifiedVoucher->offer->name.' is now '.$verifiedVoucher->offer->discount."% OFF");
                }

                //Return with an error message (Voucher already used)
                return back()->with('error', 'Voucher already used');

            }else{
                //Return with an error message (Voucher not found)
                return back()->with('error', 'Voucher not found');
            }
        }

        //Return with the validator errors
        return back()->withErrors($validator);
    }
}
