<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipient;

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
}
