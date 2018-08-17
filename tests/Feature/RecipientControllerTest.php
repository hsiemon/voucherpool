<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RecipientControllerTest extends TestCase
{
    public function testIndex()
    {
	 	$this->get('/recipients')
 			->assertStatus(200)
 			->assertViewHas('recipients');
    }

   	public function testStoreWithoutEmailValue(){
   		$this->post('/recipients/store', ['name'   => 'Test Name'])
   			->assertSessionHasErrors('email');
   	}

   	public function testStoreInvalidEmailValue(){
		$this->post('/recipients/store',['email'   => 'Test Name'])
			->assertSessionHasErrors('email');
   	}

   	public function testStoreWithoutNameValue(){
   		$this->post('/recipients/store', ['email'   => 'foo@bar.com'])
   			->assertSessionHasErrors('name');
   	}

   	public function testStoreValidValues(){
   		$this->post('/recipients/store', 
   			[
   				'name'   => 'Test Name',
   				'email'   => 'foo@bar.com',
   			])
   			->assertSessionHas('success');
   	}
}