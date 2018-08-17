<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Recipient;
use App\Models\Offer;
use App\Models\Voucher;

class VoucherControllerTest extends TestCase
{
    public function testIndex()
    {
	 	$this->get('/')
 			->assertStatus(200)
 			->assertViewHas('vouchers');
    }

    public function testGenerateWithoutOfferIdValue()
    {
   		$this->post('/vouchers/generate', ['expiration' => date('Y/m/d H:i')])
   			->assertSessionHasErrors('offer_id');
   	}

   	public function testGenerateWithoutExpirationValue()
    {
   		$this->post('/vouchers/generate', ['offer_id' => 123])
   			->assertSessionHasErrors('expiration');
   	}

   	public function testGenerateInvalidExpirationValue()
    {
   		$this->post('/vouchers/generate', ['offer_id' => 123, 'expiration' => '12/12/2010'])
   			->assertSessionHasErrors('expiration');
   	}

   	public function testGenerateValidsValues()
    {
    	$recipient = factory(Recipient::class)->make();
        $recipient->save();

        $offer = factory(Offer::class)->make();
        $offer->save();

   		$this->post('/vouchers/generate', ['offer_id' => $offer->id, 'expiration' => date('Y/m/d H:i')])
   			->assertSessionHas('success');
   	}

   	public function testRedeemWithoutEmailIdValue()
    {
   		$this->post('/vouchers/redeem', ['code' => md5('test')])
   			->assertSessionHasErrors('email');
   	}

   	public function testRedeemInvalidEmailValue()
   	{
		$this->post('/vouchers/redeem',['email'   => 'Test Name', 'code' => md5('test')])
			->assertSessionHasErrors('email');
   	}

   	public function testRedeemWithoutCodeValue()
    {
   		$this->post('/vouchers/redeem', ['email' => 'foo@bar.com'])
   			->assertSessionHasErrors('code');
   	}

   	public function testRedeemValidValues()
    {
    	$recipient = factory(Recipient::class)->make();
        $recipient->save();

        $offer = factory(Offer::class)->make();
        $offer->save();

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
