<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Recipient;
use App\Models\Offer;
use App\Models\Voucher;

/**
*   RecipientTest
*
*   Tests Case for the Recipient model
*
*   @author Henrique Siemon <henriquesiemon@msn.com>
*/
class RecipientTest extends TestCase
{
   	public function setUp()
	{
		parent::setUp();

    	$this->recipient = factory(Recipient::class)->make();
	}

    /**
    *   Tests if the application can insert a recipient in the database
    */
    public function testDatabaseInsert()
    {
        $this->assertTrue($this->recipient->save());
    }

    /**
    *   Tests if the application can update a recipient in the database
    */
    public function testDatabaseUpdate()
    {
    	$this->recipient->save();
    	$this->recipient->name = "Test Update";

     	$this->assertTrue($this->recipient->save());   
    }

    /**
    *   Tests if the application can remove a recipient in the database
    */
    public function testDatabaseRemove()
    {
    	$this->recipient->save();
    	
     	$this->assertTrue($this->recipient->delete());   
    }

    /**
    *   Tests if the application can return all vouchers assigned to a recipient
    */
    public function testListByRecipient()
    {
        // Create 3 records of Offers
        $offers = factory(Offer::class, 3)->create();
        // Create 3 records of Recipients
        $recipients = factory(Recipient::class, 3)->create();

        foreach ($offers as $offer) {
            foreach ($recipients as $recipient){
                // Seed the relation with one voucher
                $voucher = factory(Voucher::class)->make();
                $voucher->offer_id = $offer->id;
                $voucher->recipient_id = $recipient->id;
                $voucher->expiration = date("Y-m-d H:i:s", strtotime('+7 days'));

                $voucher->generateCode($recipient->email, $offer->id, $voucher->expiration)
                        ->save();
            }
        }

        $testRecipient = Recipient::find($recipients[0]->id);

        $this->assertCount(3, $testRecipient->vouchers);
        $this->assertInstanceOf(Voucher::class, $testRecipient->vouchers[0]);
    }
}
