<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Recipient;
use App\Models\Offer;
use App\Models\Voucher;

class VoucherControllerTest extends TestCase
{
    public function testRedeemInvalidRequestVoucher()
    {
        $response = $this->json('POST', '/api/vouchers/redeem');

        $response->assertStatus(400);
    }

    public function testRedeemVoucherNotFound(){
        $recipient = factory(Recipient::class)->make();

        $response = $this->json('POST', '/api/vouchers/redeem', $postData = [
            'email' => $recipient->email,
            'code' => md5($recipient->email)
        ]);

        $response->assertStatus(404);
    }

    public function testRedeemValidVoucher()
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

        $response = $this->json('POST', '/api/vouchers/redeem', $postData);

        $response->assertStatus(200)
            ->assertJson([
                'valid' => true,
            ]);
    }

    public function testRedeemExpiredVoucher(){
        $recipient = factory(Recipient::class)->make();
        $recipient->save();

        $offer = factory(Offer::class)->make();
        $offer->save();

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


    public function testRedeemAlreadyUsedVoucher(){
        $recipient = factory(Recipient::class)->make();
        $recipient->save();

        $offer = factory(Offer::class)->make();
        $offer->save();

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
