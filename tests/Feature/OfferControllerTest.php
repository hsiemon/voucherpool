<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OfferControllerTest extends TestCase
{
    public function testIndex()
    {
	 	$this->get('/offers')
 			->assertStatus(200)
 			->assertViewHas('offers');
    }

   	public function testStoreWithoutDiscountValue(){
   		$this->post('/offers/store', ['name'   => 'Test Name'])
   			->assertSessionHasErrors('discount');
   	}

   	public function testStoreInvalidDiscountValue(){
		$this->post('/offers/store',['discount'   => 'Test Discount'])
			->assertSessionHasErrors('discount');
   	}

   	public function testStoreWithoutNameValue(){
   		$this->post('/offers/store', ['discount'   => 15.5])
   			->assertSessionHasErrors('name');
   	}

   	public function testStoreValidValues(){
   		$this->post('/offers/store', 
   			[
   				'name'   => 'Test Name',
   				'discount'   => 15.5,
   			])
   			->assertSessionHas('success');
   	}
}
