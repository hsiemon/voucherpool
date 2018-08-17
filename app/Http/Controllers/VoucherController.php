<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\Recipient;
use App\Models\Offer;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::orderBy('id', 'desc')->paginate(20);
        $offers = Offer::all();

        return view('voucher.index',['vouchers' => $vouchers, 'offers' => $offers]);
    }

    public function generate(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'offer_id' => 'required',
                'expiration'  => 'required|date_format:"Y/m/d H:i"',
            ]
        );

        if($validator->passes())
        {
            try{
                $offer = Offer::findOrFail($request->offer_id);
                $recipients = Recipient::all();
                
                foreach($recipients as $recipient){
                    $voucher = factory(Voucher::class)->make();
                    $voucher->offer_id = $offer->id;
                    $voucher->recipient_id = $recipient->id;
                    $voucher->expiration = str_replace('/', '-', $request->expiration);
                    $voucher->generateCode($recipient->email, $offer->id, $voucher->expiration)
                            ->save();
                }

                return back()->with('success', 'Vouchers generated successfully');
            }catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
                return back()->with('error', 'Offer not found');
            }
        }

        return back()->withErrors($validator);
    }

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

                    return back()->with('success', 'Voucher redeemed successfully, '.$verifiedVoucher->offer->name.' is now '.$verifiedVoucher->offer->discount."% OFF");
                }

                return back()->with('error', 'Voucher already used');

            }else{
                return back()->with('error', 'Voucher not found');
            }
        }

        return back()->withErrors($validator);
    }
}
