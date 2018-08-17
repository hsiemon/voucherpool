<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->dateTime('expiration')->index()->nullable(true);
            $table->dateTime('created_at')->index(); 
            $table->dateTime('updated_at')->index()->nullable(true);
            $table->dateTime('usedAt')->index()->nullable(true); 
            $table->boolean('alreadyUsed')->default(false)->nullable(true);

            //Foreign Keys
            $table->unsignedInteger('recipient_id');
            $table->unsignedInteger('offer_id');
            $table->foreign('recipient_id')->references('id')->on('recipients');
            $table->foreign('offer_id')->references('id')->on('offers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vouchers');
    }
}
