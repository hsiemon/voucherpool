<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    //
    protected $fillable = ['name', 'discount'];
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'offers';


    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }
}
