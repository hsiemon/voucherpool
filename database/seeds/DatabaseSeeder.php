<?php

use Illuminate\Database\Seeder;

use App\Models\Offer;
use App\Models\Recipient;
use App\Models\Voucher;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 10 records of Offers
        $offers = factory(Offer::class, 10)->create();
        // Create 10 records of Recipients
        $recipients = factory(Recipient::class, 10)->create();

        foreach ($offers as $offer) {
            foreach ($recipients as $recipient){
                // Seed the relation with one voucher
                $voucher = factory(Voucher::class)->make();
                $voucher->offer_id = $offer->id;
                $voucher->recipient_id = $recipient->id;
                $voucher->expiration = date("Y-m-d H:i:s", strtotime('+30 days'));

                $voucher->generateCode($recipient->email, $offer->id, $voucher->expiration)
                        ->save();
            }
        }
        //$this->call(RecipientsTableSeeder::class);
        //$this->call(OffersTableSeeder::class);
    }
}
