<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipient;

class RecipientController extends Controller
{
    public function index()
    {
        $recipients = Recipient::orderBy('id', 'desc')->paginate(20);

        return view('recipient.index',['recipients' => $recipients]);
    }

    public function store(Request $request)
    {
       $validator = \Validator::make(
            $request->all(),
            [
                'name'      => 'required',
                'email'  => 'required|email',
            ]
        );

        if($validator->passes())
        {   
            try{
                $recipient= new Recipient;
                $recipient->name=$request->get('name');
                $recipient->email=$request->get('email');
                $recipient->save();
                
                return back()->with('success', 'Recipient added successfully');
            }catch(Exception $e){
                return back()->with('error', $e->getMessage());
            }
        }

        return back()->withErrors($validator);
    }
}
