<?php

use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use App\Email;

class EmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $emails = factory(Email::class, 5)->create();
    }
}
