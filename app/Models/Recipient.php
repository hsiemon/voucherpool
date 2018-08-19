<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
*   Recipient
*
*   Model to represent a recipient and manage database interactions
*
*   @author Henrique Siemon <henriquesiemon@msn.com>
*/
class Recipient extends Model
{
    //Fillable attributes
    protected $fillable = ['name', 'email'];
    //Guarded attributes
    protected $guarded = ['id', 'created_at', 'update_at'];
    //Recipient table
	protected $table = 'recipients';

	/**
    *	Sets a "has many" relation with the Voucher Model
    */
    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }
}
