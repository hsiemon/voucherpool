<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
*   Offer
*
*   Model to represent an offer and manage database interactions
*
*   @author Henrique Siemon <henriquesiemon@msn.com>
*/
class Offer extends Model
{
    //Fillable attributes
    protected $fillable = ['name', 'discount'];
    //Guarded attributes
    protected $guarded = ['id', 'created_at', 'update_at'];
    //Offer table
    protected $table = 'offers';

    /**
    *	Sets a "has many" relation with the Voucher Model
    */
    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }
}
