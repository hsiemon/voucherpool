<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
*   Voucher
*
*   Model to represent a voucher and manage database interactions
*
*   @author Henrique Siemon <henriquesiemon@msn.com>
*/
class Voucher extends Model
{    
    //Voucher table
    protected $table = 'vouchers';
    //Guarded attributes
    protected $guarded = [
        'id', 
        'created_at', 
        'update_at',
        'code', 
        'expiration',
        'alreadyUsed',
        'usedAt',
    ];

    /**
    *   Sets a "belongs to" relation with the Recipient Model
    */
    public function recipient()
    {
        return $this->belongsTo(Recipient::class);
    }

    /**
    *   Sets a "belongs to" relation with the Offer Model
    */
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    /**
    *   Generates a voucher code by generating a hash with an email, an offer id and a expiration date.
    *
    *   @param $email string The recipient email
    *   @param $offer_id integer The Offer ID
    *   @param $expiration datetime The expiration date
    *
    *   @return $this Voucher The object with the code generated
    */
    public function generateCode($email, $offer_id, $expiration){
        $this->code = md5($email . '-' . $offer_id . '-' . $expiration);

        return $this;
    }

    /**
    *   Validates if the Voucher is valid by checking his expiration and alreadyUsed 
    *   and returns a boolean
    *
    *   @return boolean
    */
    public function isValid(){

        //Voucher Expired
        if(!empty($this->expiration) && strtotime($this->expiration) < strtotime(date('Y-m-d H:i:s')))
            return false;

        //Voucher Already Used
        if($this->alreadyUsed)
            return false;

        return true;
    }

    /**
    *   Validates if the Voucher is valid by checking his expiration and alreadyUsed
    *   and returns an array with messages and the voucher code
    *
    *   @return Array An array with messages and the voucher code
    */
    public function validate(){
        switch (true) {
            //Voucher Already Used
            case $this->alreadyUsed == '1':
                return [
                    'valid'   => false,
                    'message' => 'Voucher already used',
                    'voucher' => $this,
                ];

            //Voucher Expired
            case !empty($this->expiration) && strtotime($this->expiration) < strtotime(date('Y-m-d H:i:s')):
                return [
                    'valid'   => false,
                    'message' => 'Expired voucher',
                    'voucher' => $this
                ];

            // Voucher is valid
            default:
                return [
                    'valid'   => true,
                    'message' => 'Voucher redeemed successfully',
                    'voucher' => $this
                ];
        }
    }
}
