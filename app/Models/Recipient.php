<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    //
    protected $fillable = ['name', 'email'];
    protected $guarded = ['id', 'created_at', 'update_at'];
	protected $table = 'recipients';


    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }
}
