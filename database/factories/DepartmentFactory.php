<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Department;
use Faker\Generator as Faker;

$factory->define(Department::class, function (Faker $faker) {
    return [
        //
        'name' => 'Area 1',
        'site_id' => factory(App\Site::class)
    ];
});
