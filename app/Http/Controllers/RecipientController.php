<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipient;
use App\Models\Voucher;

/**
*   RecipientController
*
*   Controller to manage requests related with the Recipients
*
*   @author Henrique Siemon <henriquesiemon@msn.com>
*/
class RecipientController extends Controller
{
    /**
    *   Index action to show a list of recipients
    */ 
    public function index()
    {
        //Get all recipients paginated by 20 records
        $recipients = Recipient::orderBy('id', 'desc')->paginate(20);

        return view('recipient.index',['recipients' => $recipients]);
    }
    
    /**
    *   Store action to insert an recipient in the database
    *
    *   @param $request Request Request data
    */ 
    public function store(Request $request)
    {
        //Set the validator rules
        $validator = \Validator::make(
            $request->all(),
            [
                'name'      => 'required',
                'email'  => 'required|email',
            ]
        );

        //Validate the request
        if($validator->passes())
        {   
            try{
                //Creates the recipient an insert on the database
                $recipient= new Recipient;
                $recipient->name=$request->get('name');
                $recipient->email=$request->get('email');
                $recipient->save();
                
                //Return with an success message
                return back()->with('success', 'Recipient added successfully');
            }catch(Exception $e){
                //Return with an error message
                return back()->with('error', $e->getMessage());
            }
        }

        //Return with the validator errors
        return back()->withErrors($validator);
    }

    /**
    *   List all vouchers by a certain recipient
    */ 
    public function vouchers(Request $request)
    {
        try{
            //Get the recipient
            $recipient = Recipient::findOrFail($request->id);

            //Get all recipient vouchers paginated by 20 records
            $vouchers = Voucher::where(['recipient_id' => $recipient->id])
            ->where('alreadyUsed', 0)
            ->whereRaw('expiration > "'.date('Y-m-d H:i:s').'"')
            ->paginate(20);

        }catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            //Return with an error message
            return redirect('recipients')->with('error', 'Vouchers not found');
        }

        return view('recipient.vouchers',['recipient' => $recipient, 'vouchers' => $vouchers]);
    }
}
