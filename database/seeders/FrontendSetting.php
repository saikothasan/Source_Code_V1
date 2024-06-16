<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FrontendSetting extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('frontend_settings')->insert([
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
                'value' => 'demo12@gmail.com',
            ],
            [
                'key' => 'verify_email',
                'value' => 'admin@gmail.com',
            ],
            [
                'key' => 'address',
                'value' => 'H # 14, Block # A
                Main Road
                Rampura, Banasree',
            ],
            [
                'key' => 'fb_link',
                'value' => 'facebook.com',
            ],
            [
                'key' => 'youtube_link',
                'value' => 'youtube.com'
            ],
            [
                'key' => 'about_us',
                'value' => 'about_us',
            ],
            [
                'key' => 'terms_condition',
                'value' => 'condition',
            ],
            [
                'key' => 'return_policy',
                'value' => 'return policy',
            ],
            [
                'key' => 'privacy_policy',
                'value' => 'privacy_policy',
            ],
        ]);
    }
}
