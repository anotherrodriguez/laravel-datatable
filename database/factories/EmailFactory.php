<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Email;
use App\Patient;
use Faker\Generator as Faker;

$factory->define(Email::class, function (Faker $faker) {
    return [
			'email' => $faker->freeEmail, 
			'patient_id' => factory(App\Patient::class)
    ];
});
