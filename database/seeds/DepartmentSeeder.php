<?php

use Illuminate\Database\Seeder;
use App\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $department = ['name' => 'Area 1', 'site_id' => factory(App\Site::class)];

		Department::create($department);

    }
}
