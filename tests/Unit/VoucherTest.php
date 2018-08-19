<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Voucher;
use App\Models\Recipient;
use App\Models\Offer;

/**
*   VoucherTest
*
*   Tests Case for the Voucher model
*
*   @author Henrique Siemon <henriquesiemon@msn.com>
*/
class VoucherTest extends TestCase
{
    protected $voucher;

	public function setUp(){
		parent::setUp();

        $this->recipient = factory(Recipient::class)->make();
        $this->recipient->save();

        $this->offer = factory(Offer::class)->make();
        $this->offer->save();

        $this->voucher = factory(Voucher::class)->make();
        $this->voucher->recipient_id = $this->recipient->id;
        $this->voucher->offer_id = $this->offer->id;
        $this->voucher->expiration = date('Y-m-d H:i:s', strtotime("+7 day"));
        $this->voucher->generateCode($this->recipient->email, $this->offer->id, $this->voucher->expiration);
	}

    /**
    *   Tests if the application can insert a voucher in the database
    */
    public function testDatabaseInsert()
    {
        $this->assertTrue($this->voucher->save());
    }

    /**
    *   Tests if the application can update a voucher in the database
    */
    public function testDatabaseUpdate()
    {
        $this->voucher->save();
        $this->voucher->generateCode($this->recipient->email, 21312, $this->voucher->expiration);

        $this->assertTrue($this->voucher->save());   
    }

    /**
    *   Tests if the application can remove a voucher in the database
    */
    public function testDatabaseRemove()
    {
        $this->voucher->save();
        
        $this->assertTrue($this->voucher->delete());   
    }
    
    /**
    *   Tests if the function isValid returns true on a not expirated voucher
    */
    public function testNotExpiratedIsValid()
    {    	
    	$this->voucher->expiration = date("Y-m-d H:i:s", strtotime('+30 days'));
    	$this->voucher->alreadyUsed = false;

        $this->assertTrue($this->voucher->isValid());
    }

    /**
    *   Tests if the function isValid returns false on a expirated voucher
    */
    public function testExpiratedIsInvalid()
    {
    	$this->voucher->expiration = date("Y-m-d H:i:s", strtotime('-30 days'));
    	$this->voucher->alreadyUsed = false;

        $this->assertFalse($this->voucher->isValid());
    }

    /**
    *   Tests if the function isValid returns false on a already used voucher
    */
    public function testAlreadyUsedIsInvalid()
    {
    	$this->voucher->expiration = date("Y-m-d H:i:s", strtotime('+30 days'));
    	$this->voucher->alreadyUsed = true;

        $this->assertFalse($this->voucher->isValid());
    }
}
