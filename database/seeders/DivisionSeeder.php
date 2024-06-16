<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $divsions = [
            ['id' => '1', 'country_id' => '14', 'name' => 'Chattagram', 'created_at' => '2021-03-04 15=>30=>00', 'updated_at' => '2021-03-04 15=>30=>00'],
            ['id' => '2', 'country_id' => '14', 'name' => 'Rajshahi', 'created_at' => '2021-03-04 15=>30=>00', 'updated_at' => '2021-03-04 15=>30=>00'],
            ['id' => '3', 'country_id' => '14', 'name' => 'Khulna', 'created_at' => '2021-03-04 15=>30=>00', 'updated_at' => '2021-03-04 15=>30=>00'],
            ['id' => '4', 'country_id' => '14', 'name' => 'Barisal', 'created_at' => '2021-03-04 15=>30=>00', 'updated_at' => '2021-03-04 15=>30=>00'],
            ['id' => '5', 'country_id' => '14', 'name' => 'Sylhet', 'created_at' => '2021-03-04 15=>30=>00', 'updated_at' => '2021-03-04 15=>30=>00'],
            ['id' => '6', 'country_id' => '14', 'name' => 'Dhaka', 'created_at' => '2021-03-04 15=>30=>00', 'updated_at' => '2021-03-04 15=>30=>00'],
            ['id' => '7', 'country_id' => '14', 'name' => 'Rangpur', 'created_at' => '2021-03-04 15=>30=>00', 'updated_at' => '2021-03-04 15=>30=>00'],
            ['id' => '8', 'country_id' => '14', 'name' => 'Mymensingh', 'created_at' => '2021-03-04 15=>30=>00', 'updated_at' => '2021-03-04 15=>30=>00'],
            ['id' => '9', 'country_id' => '78', 'name' => 'Andhra Pradesh', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '10', 'country_id' => '78', 'name' => 'Arunachal Pradesh', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '11', 'country_id' => '78', 'name' => 'Assam', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '12', 'country_id' => '78', 'name' => 'Bihar', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '13', 'country_id' => '78', 'name' => 'Chhattisgarh', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '14', 'country_id' => '78', 'name' => 'Goa', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '15', 'country_id' => '78', 'name' => 'Gujarat', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '16', 'country_id' => '78', 'name' => 'Haryana', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '17', 'country_id' => '78', 'name' => 'Himachal Pradesh', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '18', 'country_id' => '78', 'name' => 'Jammu Kashmir', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '19', 'country_id' => '78', 'name' => 'Jharkhand', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '20', 'country_id' => '78', 'name' => 'Karnataka', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '21', 'country_id' => '78', 'name' => 'Kerala', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '22', 'country_id' => '78', 'name' => 'Madhya Pradesh', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '23', 'country_id' => '78', 'name' => 'Maharashtra', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '24', 'country_id' => '78', 'name' => 'Manipur', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '25', 'country_id' => '78', 'name' => 'Meghalaya', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '26', 'country_id' => '78', 'name' => 'Mizoram', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '27', 'country_id' => '78', 'name' => 'Nagaland', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '28', 'country_id' => '78', 'name' => 'Odisha', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '29', 'country_id' => '78', 'name' => 'Punjab', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '30', 'country_id' => '78', 'name' => 'Rajasthan', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '31', 'country_id' => '78', 'name' => 'Sikkim', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '32', 'country_id' => '78', 'name' => 'Tamil Nadu', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '33', 'country_id' => '78', 'name' => 'Telangana', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '34', 'country_id' => '78', 'name' => 'Tripura', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '35', 'country_id' => '78', 'name' => 'Uttar Pradesh', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '36', 'country_id' => '78', 'name' => 'Uttarakhand', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '37', 'country_id' => '78', 'name' => 'West Bengal', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '38', 'country_id' => '78', 'name' => 'Andaman Nicobar', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '39', 'country_id' => '78', 'name' => 'Chandigarh', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '40', 'country_id' => '78', 'name' => 'Dadra Nagar Haveli', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '41', 'country_id' => '78', 'name' => 'Daman Diu', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '42', 'country_id' => '78', 'name' => 'Delhi', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '43', 'country_id' => '78', 'name' => 'Lakshadweep', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '44', 'country_id' => '78', 'name' => 'Ladakh', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '45', 'country_id' => '78', 'name' => 'Puducherry', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],
            ['id' => '46', 'country_id' => '78', 'name' => 'Hi', 'created_at' => '2021-03-04 09=>44=>00', 'updated_at' => '2021-03-04 09=>44=>00'],

        ];
       foreach ($divsions as $key => $value) {
           $divsion = new Division();
           $divsion->country_id = $value['country_id'];
           $divsion->name = $value['name'];
           $divsion->bn_name = null;
           $divsion->status = 1;
           $divsion->save();
       }
    }
}
