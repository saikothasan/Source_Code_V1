<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            [
                'key' => 'site_logo',
                'value' => 'images/logoheader.png',
            ],
            [
                'key' => 'site_name',
                'value' => 'MANAGEMENT SOFTWARE',
            ],
            [
                'key' => 'phone_number',
                'value' => '01883448329',
            ],
            [
                'key' => 'email',
                'value' => 'csridoy42@gmail.com',
            ],
            [
                'key' => 'verify_email',
                'value' => 'admin@gmail.com',
            ],
            [
                'key' => 'vat_percentage',
                'value' => 7.5,
            ],
            [
                'key' => 'currency_name',
                'value' => 'BDT',
            ],
            [
                'key' => 'currency_symbol',
                'value' => '',
            ],
        ]);
    }
}
