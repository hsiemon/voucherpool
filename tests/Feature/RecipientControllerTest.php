<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
*   RecipientControllerTest
*
*   Tests Case for the Recipient controller
*
*   @author Henrique Siemon <henriquesiemon@msn.com>
*/
class RecipientControllerTest extends TestCase
{
    /**
    *   Tests if the index action is available
    */
    public function testIndex()
    {
  	 	$this->get('/recipients')
   			->assertStatus(200)
   			->assertViewHas('recipients');
    }

    /**
    *   Tests if the controller returns a validation error on a post request without an email value
    */
   	public function testStoreWithoutEmailValue()
    {
   		$this->post('/recipients/store', ['name'   => 'Test Name'])
   			->assertSessionHasErrors('email');
   	}

    /**
    *   Tests if the controller returns a validation error on a post request with an invalid email value
    */
   	public function testStoreInvalidEmailValue()
    {
		  $this->post('/recipients/store',['email'   => 'Test Name'])
        ->assertSessionHasErrors('email');
   	}

    /**
    *   Tests if the controller returns a validation error on a post request without an name value
    */
   	public function testStoreWithoutNameValue()
    {
   		$this->post('/recipients/store', ['email'   => 'foo@bar.com'])
   			->assertSessionHasErrors('name');
   	}

    /**
    *   Tests if the controller returns a success message on a valid post submit
    */
   	public function testStoreValidValues()
    {
   		$this->post('/recipients/store', 
   			[
   				'name'   => 'Test Name',
   				'email'   => 'foo@bar.com',
   			])
   			->assertSessionHas('success');
   	}
}