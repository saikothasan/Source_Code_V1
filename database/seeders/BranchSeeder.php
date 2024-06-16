<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('branches')->insert([
            [
                'date' => date('Y-m-d'),
                'name' => 'Main Branch',
                'branch_id' => '112023',
                'address' => 'Banasree, Dhaka',
                'contact_person' => '01883448329',
                'is_main_branch' => 1,
            ],
            [
                'date' => date('Y-m-d'),
                'name' => 'F Block Branch',
                'branch_id' => '225225',
                'address' => 'F Block Branch',
                'contact_person' => '01683448329',
                'is_main_branch' => 0,
            ],
            [
                'date' => date('Y-m-d'),
                'name' => 'B-Block ShowRoom',
                'branch_id' => '555225',
                'address' => 'B-Block ShowRoom',
                'contact_person' => '01683448324',
                'is_main_branch' => 0,
            ],
        ]);
    }
}
