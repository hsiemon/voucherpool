<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{    
    protected $table = 'vouchers';
    protected $guarded = [
        'id', 
        'created_at', 
        'update_at',
        'code', 
        'expiration',
        'alreadyUsed',
        'usedAt',
    ];

    public function recipient()
    {
        return $this->belongsTo(Recipient::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function generateCode($email, $offer_id, $expiration){
        $this->code = md5($email . '-' . $offer_id . '-' . $expiration);

        return $this;
    }

    public function isValid(){

        //Voucher Expired
        if(!empty($this->expiration) && strtotime($this->expiration) < strtotime(date('Y-m-d H:i:s')))
            return false;

        //Voucher Already Used
        if($this->alreadyUsed)
            return false;

        return true;
    }

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
