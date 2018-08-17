<?php

use App\Models\Offer;
use App\Models\Recipient;
use App\Models\Voucher;

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Recipient::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'created_at' => date("Y-m-d H:i:s")
    ];
});

$factory->define(Offer::class, function (Faker $faker) {
    return [
        'name' => $faker->bs,
        'discount' => $faker->randomFloat(2, 0, 70) ,
        'created_at' => date("Y-m-d H:i:s"),
    ];
});

$factory->define(Voucher::class, function (Faker $faker) {
    return [
    	'created_at' => date("Y-m-d H:i:s")
    ];
});