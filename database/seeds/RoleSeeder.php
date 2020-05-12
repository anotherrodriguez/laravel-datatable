<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $roles = [
	        ['name' => 'new'],
	        ['name' => 'user'],
	        ['name' => 'admin'],
	        ['name' => 'super_admin']
    	];

        foreach($roles as $role){
		    Role::create($role);
		}

    }
}
