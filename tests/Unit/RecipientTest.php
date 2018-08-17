<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Recipient;

class RecipientTest extends TestCase
{
   	public function setUp()
	{
		parent::setUp();

    	$this->recipient = factory(Recipient::class)->make();
	}

    public function testDatabaseInsert()
    {
        $this->assertTrue($this->recipient->save());
    }

    public function testDatabaseUpdate()
    {
    	$this->recipient->save();
    	$this->recipient->name = "Test Update";

     	$this->assertTrue($this->recipient->save());   
    }

    public function testDatabaseRemove()
    {
    	$this->recipient->save();
    	
     	$this->assertTrue($this->recipient->delete());   
    }
}
