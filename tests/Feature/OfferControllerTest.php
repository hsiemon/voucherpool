<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
*   OfferControllerTest
*
*   Tests Case for the Offer controller
*
*   @author Henrique Siemon <henriquesiemon@msn.com>
*/
class OfferControllerTest extends TestCase
{
  /**
  *   Tests if the index action is available
  */
  public function testIndex()
  {
    $this->get('/offers')
			  ->assertStatus(200)
			  ->assertViewHas('offers');
  }

  /**
  *   Tests if the controller returns a validation error on a post request without an discount value
  */
 	public function testStoreWithoutDiscountValue()
  {
 		$this->post('/offers/store', ['name'   => 'Test Name'])
 			->assertSessionHasErrors('discount');
 	}

  /**
  *   Tests if the controller returns a validation error on a post request with an invalid discount value
  */
 	public function testStoreInvalidDiscountValue()
  {
	  $this->post('/offers/store',['discount'   => 'Test Discount'])
      ->assertSessionHasErrors('discount');
 	}

  /**
  *   Tests if the controller returns a validation error on a post request without an name value
  */
 	public function testStoreWithoutNameValue()
  {
 		$this->post('/offers/store', ['discount'   => 15.5])
 			->assertSessionHasErrors('name');
 	}

  /**
  *   Tests if the controller returns a success message on a valid post submit
  */
 	public function testStoreValidValues()
  {
 		$this->post('/offers/store', 
 			[
 				'name'   => 'Test Name',
 				'discount'   => 15.5,
 			])
 			->assertSessionHas('success');
 	}
}
