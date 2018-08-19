<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Recipient;

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
}
