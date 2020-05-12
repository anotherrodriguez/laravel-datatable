<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Status;
use App\Department;
use Faker\Generator as Faker;

$factory->define(Status::class, function (Faker $faker) {
    return [
        'name' => 'Signed Up', 
        'department_id' => factory(App\Department::class), 
        'list_order' => 0
    ];
});
