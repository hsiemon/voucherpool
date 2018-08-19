<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Recipient;
use App\Models\Voucher;

/**
*   VoucherController
*
*   Controller to manage API requests related with the Vouchers
*
*   @author Henrique Siemon <henriquesiemon@msn.com>
*/
class VoucherController extends Controller
{
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
                }

                //Return with the voucher info
                return response()->json($isVoucherValid, 200);

            }else{
                //Return with an error message
                return response()->json(null, 404);
            }
        }

        //Return with the validator errors
        return response()->json(null, 400);
    }
}
