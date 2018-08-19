<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Recipient;
use App\Models\Offer;
use App\Models\Voucher;

/**
*   VoucherControllerTest
*
*   Tests Case for the Voucher controller
*
*   @author Henrique Siemon <henriquesiemon@msn.com>
*/
class VoucherControllerTest extends TestCase
{
    /**
    *   Tests if the index action is available
    */
    public function testIndex()
    {
  	 	$this->get('/')
   			->assertStatus(200)
   			->assertViewHas('vouchers');
    }

    /**
    *   Tests if the controller returns a validation error on a post request 
    *   to the generate function without an offer id value
    */
    public function testGenerateWithoutOfferIdValue()
    {
   		$this->post('/vouchers/generate', ['expiration' => date('Y/m/d H:i')])
   			->assertSessionHasErrors('offer_id');
   	}

    /**
    *   Tests if the controller returns a validation error on a post request 
    *   to the generate function without an expiration value
    */
   	public function testGenerateWithoutExpirationValue()
    {
   		$this->post('/vouchers/generate', ['offer_id' => 123])
   			->assertSessionHasErrors('expiration');
   	}

    /**
    *   Tests if the controller returns a validation error on a post request 
    *   to the generate function with an invalid expiration value
    */
   	public function testGenerateInvalidExpirationValue()
    {
   		$this->post('/vouchers/generate', ['offer_id' => 123, 'expiration' => '12/12/2010'])
   			->assertSessionHasErrors('expiration');
   	}

    /**
    *   Tests if the controller returns a success message on the generate function 
    *   with a valid post submit
    */
   	public function testGenerateValidsValues()
    {
    	$recipient = factory(Recipient::class)->make();
        $recipient->save();

        $offer = factory(Offer::class)->make();
        $offer->save();

   		$this->post('/vouchers/generate', ['offer_id' => $offer->id, 'expiration' => date('Y/m/d H:i')])
   			->assertSessionHas('success');
   	}

    /**
    *   Tests if the controller returns a validation error on a post request 
    *   to the redeem function without an email value
    */
   	public function testRedeemWithoutEmailIdValue()
    {
   		$this->post('/vouchers/redeem', ['code' => md5('test')])
   			->assertSessionHasErrors('email');
   	}

    /**
    *   Tests if the controller returns a validation error on a post request 
    *   to the redeem function with an invalid email value
    */
   	public function testRedeemInvalidEmailValue()
   	{
  		$this->post('/vouchers/redeem',['email'   => 'Test Name', 'code' => md5('test')])
  			->assertSessionHasErrors('email');
   	}

    /**
    *   Tests if the controller returns a validation error on a post request 
    *   to the redeem function without an code value
    */
   	public function testRedeemWithoutCodeValue()
    {
   		$this->post('/vouchers/redeem', ['email' => 'foo@bar.com'])
   			->assertSessionHasErrors('code');
   	}

    /**
    *   Tests if the controller returns a success message on the redeem function with 
    *   a valid post submit
    */
   	public function testRedeemValidValues()
    {
      //Generate the recipient using a factory and save on database
      $recipient = factory(Recipient::class)->make();
      $recipient->save();

      //Generate the offer using a factory and save on database
      $offer = factory(Offer::class)->make();
      $offer->save();

      //Generate the recipient using a factory and save on database
      $voucher = factory(Voucher::class)->make();
      $voucher->recipient_id = $recipient->id;
      $voucher->offer_id = $offer->id;
      $voucher->expiration = date('Y-m-d H:i:s', strtotime("+7 day"));
      $voucher->generateCode($recipient->email, $offer->id, $voucher->expiration)
              ->save();

      $postData = [
          'email' => $recipient->email,
          'code' => $voucher->code
      ];

   		$this->post('/vouchers/redeem', $postData)
   			->assertSessionHas('success');
   	}
}
