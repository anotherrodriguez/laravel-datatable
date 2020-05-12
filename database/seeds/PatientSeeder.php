<?php

use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use App\Patient;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $patient = factory(App\Patient::class, 3)->create();

    }
}
