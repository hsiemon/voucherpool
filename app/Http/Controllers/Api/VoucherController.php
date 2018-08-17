<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Recipient;
use App\Models\Voucher;

class VoucherController extends Controller
{
    public function redeem(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'code'  => 'required',
            ]
        );

        if($validator->passes())
        {   
            $recipient = Recipient::where(['email' => $request->email])->first();

            if($recipient && 
                $verifiedVoucher = Voucher::where('recipient_id', $recipient->id)
                ->where('code', $request->code)
                ->first()){

                $isVoucherValid = $verifiedVoucher->validate();

                if($isVoucherValid['valid']===true && empty($verifiedVoucher->usedAt)){
                    $verifiedVoucher->usedAt = date('Y-m-d H:i:s');
                    $verifiedVoucher->alreadyUsed = true;
                    $verifiedVoucher->save(); 
                }

                return response()->json($isVoucherValid, 200);

            }else{
                return response()->json(null, 404);
            }
        }

        return response()->json(null, 400);
    }
}
