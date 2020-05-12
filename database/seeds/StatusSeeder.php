<?php

use Illuminate\Database\Seeder;
use App\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $status = ['name' => 'Signed Up', 'department_id' => factory(App\Department::class), 'list_order' => 0];

		Status::create($status);

    }
}
