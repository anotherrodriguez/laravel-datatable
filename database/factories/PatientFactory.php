<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Patient;
use App\Status;
use Faker\Generator as Faker;

$factory->define(Patient::class, function (Faker $faker) {
    return [
		'first_name' => $faker->firstNameFemale, 
		'last_name' => $faker->lastName, 
		'date_of_service' => $faker->date, 
		'status_id' => factory(App\Status::class)
		  ];
});
