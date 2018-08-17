<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Offer;

class OfferTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();

    	$this->offer = factory(Offer::class)->make();
	}

    public function testDatabaseInsert()
    {
        $this->assertTrue($this->offer->save());
    }

    public function testDatabaseUpdate()
    {
    	$this->offer->save();
    	$this->offer->name = "Test Update";

     	$this->assertTrue($this->offer->save());   
    }

    public function testDatabaseRemove()
    {
    	$this->offer->save();

     	$this->assertTrue($this->offer->delete());   
    }
}
