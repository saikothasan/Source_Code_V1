<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'Sale',
            'Product',
            'Purchase',
            'Cost',
            'Payment Method',
            'Owner',
            'Bank',
            'Cash',
            'Customer',
            'Supplier',
            'Report',
            'Product Transfer',
            'User',
            'Employee Management',
            'Department',
            'Employee',
            'Settings',
            'Language',
            'Attendance',
            'Bar Code',
            'Quotation',
            'All',
        ];

        foreach($permissions as $permission){
            Permission::create(['name' => $permission]);
        }
        
    }
}
