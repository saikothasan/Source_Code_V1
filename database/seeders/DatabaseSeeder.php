<?php

use Database\Seeders\BranchSeeder;
use Database\Seeders\DesignationSeeder;
use Database\Seeders\SettingSeeder;
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
         $this->call(DesignationSeeder::class);
         $this->call(BranchSeeder::class);
         $this->call(SettingSeeder::class);
    }
}
