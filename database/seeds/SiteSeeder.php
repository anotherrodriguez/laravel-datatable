<?php

use Illuminate\Database\Seeder;
use App\Site;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $sites = factory(Site::class, 10)->create();
    }
}
