<?php

namespace Tests\Feature\Api;

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
*   Tests Case for the API Voucher controller
*
*   @author Henrique Siemon <henriquesiemon@msn.com>
*/
class VoucherControllerTest extends TestCase
{
    /**
    *   Tests if the API controller returns an http code 400 on a post request 
    *   to the redeem function without any value
    */
    public function testRedeemInvalidRequestVoucher()
    {
        $response = $this->json('POST', '/api/vouchers/redeem');

        $response->assertStatus(400);
    }

    /**
    *   Tests if the API controller returns an http code 404 on a post request 
    *   to the redeem function with invalid values
    */
    public function testRedeemVoucherNotFound(){
        $recipient = factory(Recipient::class)->make();

        $response = $this->json('POST', '/api/vouchers/redeem', $postData = [
            'email' => $recipient->email,
            'code' => md5($recipient->email)
        ]);

        $response->assertStatus(404);
    }

    /**
    *   Tests if the API controller returns a 200 http code and a success message on the redeem function with 
    *   a valid post submit
    */
    public function testRedeemValidVoucher()
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

        $response = $this->json('POST', '/api/vouchers/redeem', $postData);

        $response->assertStatus(200)
            ->assertJson([
                'valid' => true,
            ]);
    }

    /**
    *   Tests if the API controller returns an http code 200 and a error message on a post request 
    *   to the redeem function with an expired voucher
    */
    public function testRedeemExpiredVoucher(){
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
        $voucher->expiration = "1900-01-01 00:00:00";
        $voucher->generateCode($recipient->email, $offer->id, $voucher->expiration)
                ->save();

        $postData = [
            'email' => $recipient->email,
            'code' => $voucher->code
        ];

        $response = $this->json('POST', '/api/vouchers/redeem', $postData);

        $response->assertStatus(200)
            ->assertJson([
                'valid' => false,
                'message' => "Expired voucher"
            ]);
    }

    /**
    *   Tests if the API controller returns an http code 200 and a error message on a post request 
    *   to the redeem function with an already used voucher 
    */
    public function testRedeemAlreadyUsedVoucher(){
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
        $voucher->alreadyUsed = 1;
        $voucher->usedAt = date('Y-m-d H:i:s');
        $voucher->expiration = date('Y-m-d H:i:s', strtotime("+7 day"));
        $voucher->generateCode($recipient->email, $offer->id, $voucher->expiration)
                ->save();

        $postData = [
            'email' => $recipient->email,
            'code' => $voucher->code
        ];

        $response = $this->json('POST', '/api/vouchers/redeem', $postData);

        $response->assertStatus(200)
            ->assertJson([
                'valid' => false,
                'message' => "Voucher already used"
            ]);
    }

}
