<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Offer;

/**
*   OfferTest
*
*   Tests Case for the Offer model
*
*   @author Henrique Siemon <henriquesiemon@msn.com>
*/
class OfferTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();

    	$this->offer = factory(Offer::class)->make();
	}

    /**
    *   Tests if the application can insert a offer in the database
    */
    public function testDatabaseInsert()
    {
        $this->assertTrue($this->offer->save());
    }

    /**
    *   Tests if the application can update a offer in the database
    */
    public function testDatabaseUpdate()
    {
    	$this->offer->save();
    	$this->offer->name = "Test Update";

     	$this->assertTrue($this->offer->save());   
    }

    /**
    *   Tests if the application can remove a offer in the database
    */
    public function testDatabaseRemove()
    {
    	$this->offer->save();

     	$this->assertTrue($this->offer->delete());   
    }
}
