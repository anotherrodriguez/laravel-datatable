<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

    Artisan::call('migrate:fresh');

    DB::table('sites')->insert([
        'name' => 'Woodhull Hospital',
        'address' => '760 Broadway',
        'city' => 'Brooklyn',
        'state' => 'NY',
        'zip_code' => '11206',
        'created_at' => now(),
        'updated_at' => now()
    ]);

    DB::table('roles')->insert([
        ['name' => 'new', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'user', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'admin', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'super_admin', 'created_at' => now(), 'updated_at' => now()]
    ]);

    DB::table('users')->insert([
        'name' => 'Admin',
        'email' => 'unthinkablecreation@gmail.com',
        'email_verified_at' => now(),
        'password' => Hash::make('password'), // password
        'role_id' => 4,
        'site_id' => 1,
        'created_at' => now(),
        'updated_at' => now()
    ]);

    DB::table('departments')->insert([
        'name' => 'Area 1', 'site_id' => '1', 'created_at' => now(), 'updated_at' => now()
    ]);

    DB::table('statuses')->insert([
        'name' => 'Signed Up', 
        'department_id' => '1', 
        'list_order' => 0,
        'created_at' => now(),
        'updated_at' => now()
    ]);

/*
    $this->call([
        EmailSeeder::class,
        SiteSeeder::class,
    ]);
    */

    }
}
