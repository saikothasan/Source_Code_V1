<?php

namespace Database\Seeders;

use App\Models\District;
use App\Services\BookService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Throwable;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $districts =
            [
                [
                    'id' => '1',
                    'country_id' => '14',
                    'division_id' => '1',
                    'name' => 'Comilla',

                ],
                [
                    'id' => '2',
                    'country_id' => '14',
                    'division_id' => '1',
                    'name' => 'Feni',

                ],
                [
                    'id' => '3',
                    'country_id' => '14',
                    'division_id' => '1',
                    'name' => 'Brahmanbaria',

                ],
                [
                    'id' => '4',
                    'country_id' => '14',
                    'division_id' => '1',
                    'name' => 'Rangamati',

                ],
                [
                    'id' => '5',
                    'country_id' => '14',
                    'division_id' => '1',
                    'name' => 'Noakhali',

                ],
                [
                    'id' => '6',
                    'country_id' => '14',
                    'division_id' => '1',
                    'name' => 'Chandpur',

                ],
                [
                    'id' => '7',
                    'country_id' => '14',
                    'division_id' => '1',
                    'name' => 'Lakshmipur',

                ],
                [
                    'id' => '8',
                    'country_id' => '14',
                    'division_id' => '1',
                    'name' => 'Chattogram',

                ],
                [
                    'id' => '9',
                    'country_id' => '14',
                    'division_id' => '1',
                    'name' => 'Coxsbazar',

                ],
                [
                    'id' => '10',
                    'country_id' => '14',
                    'division_id' => '1',
                    'name' => 'Khagrachhari',

                ],
                [
                    'id' => '11',
                    'country_id' => '14',
                    'division_id' => '1',
                    'name' => 'Bandarban',

                ],
                [
                    'id' => '12',
                    'country_id' => '14',
                    'division_id' => '2',
                    'name' => 'Sirajganj',

                ],
                [
                    'id' => '13',
                    'country_id' => '14',
                    'division_id' => '2',
                    'name' => 'Pabna',

                ],
                [
                    'id' => '14',
                    'country_id' => '14',
                    'division_id' => '2',
                    'name' => 'Bogura',

                ],
                [
                    'id' => '15',
                    'country_id' => '14',
                    'division_id' => '2',
                    'name' => 'Rajshahi',

                ],
                [
                    'id' => '16',
                    'country_id' => '14',
                    'division_id' => '2',
                    'name' => 'Natore',

                ],
                [
                    'id' => '17',
                    'country_id' => '14',
                    'division_id' => '2',
                    'name' => 'Joypurhat',

                ],
                [
                    'id' => '18',
                    'country_id' => '14',
                    'division_id' => '2',
                    'name' => 'Chapainawabganj',

                ],
                [
                    'id' => '19',
                    'country_id' => '14',
                    'division_id' => '2',
                    'name' => 'Naogaon',

                ],
                [
                    'id' => '20',
                    'country_id' => '14',
                    'division_id' => '3',
                    'name' => 'Jashore',

                ],
                [
                    'id' => '21',
                    'country_id' => '14',
                    'division_id' => '3',
                    'name' => 'Satkhira',

                ],
                [
                    'id' => '22',
                    'country_id' => '14',
                    'division_id' => '3',
                    'name' => 'Meherpur',

                ],
                [
                    'id' => '23',
                    'country_id' => '14',
                    'division_id' => '3',
                    'name' => 'Narail',

                ],
                [
                    'id' => '24',
                    'country_id' => '14',
                    'division_id' => '3',
                    'name' => 'Chuadanga',

                ],
                [
                    'id' => '25',
                    'country_id' => '14',
                    'division_id' => '3',
                    'name' => 'Kushtia',

                ],
                [
                    'id' => '26',
                    'country_id' => '14',
                    'division_id' => '3',
                    'name' => 'Magura',

                ],
                [
                    'id' => '27',
                    'country_id' => '14',
                    'division_id' => '3',
                    'name' => 'Khulna',

                ],
                [
                    'id' => '28',
                    'country_id' => '14',
                    'division_id' => '3',
                    'name' => 'Bagerhat',

                ],
                [
                    'id' => '29',
                    'country_id' => '14',
                    'division_id' => '3',
                    'name' => 'Jhenaidah',

                ],
                [
                    'id' => '30',
                    'country_id' => '14',
                    'division_id' => '4',
                    'name' => 'Jhalakathi',

                ],
                [
                    'id' => '31',
                    'country_id' => '14',
                    'division_id' => '4',
                    'name' => 'Patuakhali',

                ],
                [
                    'id' => '32',
                    'country_id' => '14',
                    'division_id' => '4',
                    'name' => 'Pirojpur',

                ],
                [
                    'id' => '33',
                    'country_id' => '14',
                    'division_id' => '4',
                    'name' => 'Barisal',

                ],
                [
                    'id' => '34',
                    'country_id' => '14',
                    'division_id' => '4',
                    'name' => 'Bhola',

                ],
                [
                    'id' => '35',
                    'country_id' => '14',
                    'division_id' => '4',
                    'name' => 'Barguna',

                ],
                [
                    'id' => '36',
                    'country_id' => '14',
                    'division_id' => '5',
                    'name' => 'Sylhet',

                ],
                [
                    'id' => '37',
                    'country_id' => '14',
                    'division_id' => '5',
                    'name' => 'Moulvibazar',

                ],
                [
                    'id' => '38',
                    'country_id' => '14',
                    'division_id' => '5',
                    'name' => 'Habiganj',

                ],
                [
                    'id' => '39',
                    'country_id' => '14',
                    'division_id' => '5',
                    'name' => 'Sunamganj',

                ],
                [
                    'id' => '40',
                    'country_id' => '14',
                    'division_id' => '6',
                    'name' => 'Narsingdi',

                ],
                [
                    'id' => '41',
                    'country_id' => '14',
                    'division_id' => '6',
                    'name' => 'Gazipur',

                ],
                [
                    'id' => '42',
                    'country_id' => '14',
                    'division_id' => '6',
                    'name' => 'Shariatpur',

                ],
                [
                    'id' => '43',
                    'country_id' => '14',
                    'division_id' => '6',
                    'name' => 'Narayanganj',

                ],
                [
                    'id' => '44',
                    'country_id' => '14',
                    'division_id' => '6',
                    'name' => 'Tangail',

                ],
                [
                    'id' => '45',
                    'country_id' => '14',
                    'division_id' => '6',
                    'name' => 'Kishoreganj',

                ],
                [
                    'id' => '46',
                    'country_id' => '14',
                    'division_id' => '6',
                    'name' => 'Manikganj',

                ],
                [
                    'id' => '47',
                    'country_id' => '14',
                    'division_id' => '6',
                    'name' => 'Dhaka',

                ],
                [
                    'id' => '48',
                    'country_id' => '14',
                    'division_id' => '6',
                    'name' => 'Munshiganj',

                ],
                [
                    'id' => '49',
                    'country_id' => '14',
                    'division_id' => '6',
                    'name' => 'Rajbari',

                ],
                [
                    'id' => '50',
                    'country_id' => '14',
                    'division_id' => '6',
                    'name' => 'Madaripur',

                ],
                [
                    'id' => '51',
                    'country_id' => '14',
                    'division_id' => '6',
                    'name' => 'Gopalganj',

                ],
                [
                    'id' => '52',
                    'country_id' => '14',
                    'division_id' => '6',
                    'name' => 'Faridpur',

                ],
                [
                    'id' => '53',
                    'country_id' => '14',
                    'division_id' => '7',
                    'name' => 'Panchagarh',

                ],
                [
                    'id' => '54',
                    'country_id' => '14',
                    'division_id' => '7',
                    'name' => 'Dinajpur',

                ],
                [
                    'id' => '55',
                    'country_id' => '14',
                    'division_id' => '7',
                    'name' => 'Lalmonirhat',

                ],
                [
                    'id' => '56',
                    'country_id' => '14',
                    'division_id' => '7',
                    'name' => 'Nilphamari',

                ],
                [
                    'id' => '57',
                    'country_id' => '14',
                    'division_id' => '7',
                    'name' => 'Gaibandha',

                ],
                [
                    'id' => '58',
                    'country_id' => '14',
                    'division_id' => '7',
                    'name' => 'Thakurgaon',

                ],
                [
                    'id' => '59',
                    'country_id' => '14',
                    'division_id' => '7',
                    'name' => 'Rangpur',

                ],
                [
                    'id' => '60',
                    'country_id' => '14',
                    'division_id' => '7',
                    'name' => 'Kurigram',

                ],
                [
                    'id' => '61',
                    'country_id' => '14',
                    'division_id' => '8',
                    'name' => 'Sherpur',

                ],
                [
                    'id' => '62',
                    'country_id' => '14',
                    'division_id' => '8',
                    'name' => 'Mymensingh',

                ],
                [
                    'id' => '63',
                    'country_id' => '14',
                    'division_id' => '8',
                    'name' => 'Jamalpur',

                ],
                [
                    'id' => '64',
                    'country_id' => '14',
                    'division_id' => '8',
                    'name' => 'Netrokona',

                ],
                [
                    'id' => '806',
                    'country_id' => '78',
                    'division_id' => '9',
                    'name' => 'Anantapur',

                ],
                [
                    'id' => '807',
                    'country_id' => '78',
                    'division_id' => '9',
                    'name' => 'Chittoor',

                ],
                [
                    'id' => '808',
                    'country_id' => '78',
                    'division_id' => '9',
                    'name' => 'East Godavari',

                ],
                [
                    'id' => '809',
                    'country_id' => '78',
                    'division_id' => '9',
                    'name' => 'Guntur',

                ],
                [
                    'id' => '810',
                    'country_id' => '78',
                    'division_id' => '9',
                    'name' => 'Kadapa',

                ],
                [
                    'id' => '811',
                    'country_id' => '78',
                    'division_id' => '9',
                    'name' => 'Krishna',

                ],
                [
                    'id' => '812',
                    'country_id' => '78',
                    'division_id' => '9',
                    'name' => 'Kurnool',

                ],
                [
                    'id' => '813',
                    'country_id' => '78',
                    'division_id' => '9',
                    'name' => 'Nellore',

                ],
                [
                    'id' => '814',
                    'country_id' => '78',
                    'division_id' => '9',
                    'name' => 'Prakasam',

                ],
                [
                    'id' => '815',
                    'country_id' => '78',
                    'division_id' => '9',
                    'name' => 'Srikakulam',

                ],
                [
                    'id' => '816',
                    'country_id' => '78',
                    'division_id' => '9',
                    'name' => 'Visakhapatnam',

                ],
                [
                    'id' => '817',
                    'country_id' => '78',
                    'division_id' => '9',
                    'name' => 'Vizianagaram',

                ],
                [
                    'id' => '818',
                    'country_id' => '78',
                    'division_id' => '9',
                    'name' => 'West Godavari',

                ],
                [
                    'id' => '819',
                    'country_id' => '78',
                    'division_id' => '10',
                    'name' => 'Anjaw',

                ],
                [
                    'id' => '820',
                    'country_id' => '78',
                    'division_id' => '10',
                    'name' => 'Siang',

                ],
                [
                    'id' => '821',
                    'country_id' => '78',
                    'division_id' => '10',
                    'name' => 'Changlang',

                ],
                [
                    'id' => '822',
                    'country_id' => '78',
                    'division_id' => '10',
                    'name' => 'Dibang Valley',

                ],
                [
                    'id' => '823',
                    'country_id' => '78',
                    'division_id' => '10',
                    'name' => 'East Kameng',

                ],
                [
                    'id' => '824',
                    'country_id' => '78',
                    'division_id' => '10',
                    'name' => 'East Siang',

                ],
                [
                    'id' => '825',
                    'country_id' => '78',
                    'division_id' => '10',
                    'name' => 'Kamle',

                ],
                [
                    'id' => '826',
                    'country_id' => '78',
                    'division_id' => '10',
                    'name' => 'Kra Daadi',

                ],
                [
                    'id' => '827',
                    'country_id' => '78',
                    'division_id' => '10',
                    'name' => 'Kurung Kumey',

                ],
                [
                    'id' => '828',
                    'country_id' => '78',
                    'division_id' => '10',
                    'name' => 'Lepa Rada',

                ],
                [
                    'id' => '829',
                    'country_id' => '78',
                    'division_id' => '10',
                    'name' => 'Lohit',

                ],
                [
                    'id' => '830',
                    'country_id' => '78',
                    'division_id' => '10',
                    'name' => 'Longding',

                ],
                [
                    'id' => '831',
                    'country_id' => '78',
                    'division_id' => '10',
                    'name' => 'Lower Dibang Valley',

                ],
                [
                    'id' => '832',
                    'country_id' => '78',
                    'division_id' => '10',
                    'name' => 'Lower Siang',

                ],
                [
                    'id' => '833',
                    'country_id' => '78',
                    'division_id' => '10',
                    'name' => 'Lower Subansiri',

                ],
                [
                    'id' => '834',
                    'country_id' => '78',
                    'division_id' => '10',
                    'name' => 'Namsai',

                ],
                [
                    'id' => '835',
                    'country_id' => '78',
                    'division_id' => '10',
                    'name' => 'Pakke Kessang',

                ],
                [
                    'id' => '836',
                    'country_id' => '78',
                    'division_id' => '10',
                    'name' => 'Papum Pare',

                ],
                [
                    'id' => '837',
                    'country_id' => '78',
                    'division_id' => '10',
                    'name' => 'Shi Yomi',

                ],
                [
                    'id' => '838',
                    'country_id' => '78',
                    'division_id' => '10',
                    'name' => 'Tawang',

                ],
                [
                    'id' => '839',
                    'country_id' => '78',
                    'division_id' => '10',
                    'name' => 'Tirap',

                ],
                [
                    'id' => '840',
                    'country_id' => '78',
                    'division_id' => '10',
                    'name' => 'Upper Siang',

                ],
                [
                    'id' => '841',
                    'country_id' => '78',
                    'division_id' => '10',
                    'name' => 'Upper Subansiri',

                ],
                [
                    'id' => '842',
                    'country_id' => '78',
                    'division_id' => '10',
                    'name' => 'West Kameng',

                ],
                [
                    'id' => '843',
                    'country_id' => '78',
                    'division_id' => '10',
                    'name' => 'West Siang',

                ],
                [
                    'id' => '844',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Bajali',

                ],
                [
                    'id' => '845',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Baksa',

                ],
                [
                    'id' => '846',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Barpeta',

                ],
                [
                    'id' => '847',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Biswanath',

                ],
                [
                    'id' => '848',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Bongaigaon',

                ],
                [
                    'id' => '849',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Cachar',

                ],
                [
                    'id' => '850',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Charaideo',

                ],
                [
                    'id' => '851',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Chirang',

                ],
                [
                    'id' => '852',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Darrang',

                ],
                [
                    'id' => '853',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Dhemaji',

                ],
                [
                    'id' => '854',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Dhubri',

                ],
                [
                    'id' => '855',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Dibrugarh',

                ],
                [
                    'id' => '856',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Dima Hasao',

                ],
                [
                    'id' => '857',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Goalpara',

                ],
                [
                    'id' => '858',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Golaghat',

                ],
                [
                    'id' => '859',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Hailakandi',

                ],
                [
                    'id' => '860',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Hojai',

                ],
                [
                    'id' => '861',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Jorhat',

                ],
                [
                    'id' => '862',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Kamrup',

                ],
                [
                    'id' => '863',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Kamrup Metropolitan',

                ],
                [
                    'id' => '864',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Karbi Anglong',

                ],
                [
                    'id' => '865',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Karimganj',

                ],
                [
                    'id' => '866',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Kokrajhar',

                ],
                [
                    'id' => '867',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Lakhimpur',

                ],
                [
                    'id' => '868',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Majuli',

                ],
                [
                    'id' => '869',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Morigaon',

                ],
                [
                    'id' => '870',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Nagaon',

                ],
                [
                    'id' => '871',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Nalbari',

                ],
                [
                    'id' => '872',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Sivasagar',

                ],
                [
                    'id' => '873',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Sonitpur',

                ],
                [
                    'id' => '874',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'South Salmara-Mankachar',

                ],
                [
                    'id' => '875',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Tinsukia',

                ],
                [
                    'id' => '876',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'Udalguri',

                ],
                [
                    'id' => '877',
                    'country_id' => '78',
                    'division_id' => '11',
                    'name' => 'West Karbi Anglong',

                ],
                [
                    'id' => '878',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Araria',

                ],
                [
                    'id' => '879',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Arwal',

                ],
                [
                    'id' => '880',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Aurangabad',

                ],
                [
                    'id' => '881',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Banka',

                ],
                [
                    'id' => '882',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Begusarai',

                ],
                [
                    'id' => '883',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Bhagalpur',

                ],
                [
                    'id' => '884',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Bhojpur',

                ],
                [
                    'id' => '885',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Buxar',

                ],
                [
                    'id' => '886',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Darbhanga',

                ],
                [
                    'id' => '887',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'East Champaran',

                ],
                [
                    'id' => '888',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Gaya',

                ],
                [
                    'id' => '889',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Gopalganj',

                ],
                [
                    'id' => '890',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Jamui',

                ],
                [
                    'id' => '891',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Jehanabad',

                ],
                [
                    'id' => '892',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Kaimur',

                ],
                [
                    'id' => '893',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Katihar',

                ],
                [
                    'id' => '894',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Khagaria',

                ],
                [
                    'id' => '895',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Kishanganj',

                ],
                [
                    'id' => '896',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Lakhisarai',

                ],
                [
                    'id' => '897',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Madhepura',

                ],
                [
                    'id' => '898',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Madhubani',

                ],
                [
                    'id' => '899',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Munger',

                ],
                [
                    'id' => '900',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Muzaffarpur',

                ],
                [
                    'id' => '901',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Nalanda',

                ],
                [
                    'id' => '902',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Nawada',

                ],
                [
                    'id' => '903',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Patna',

                ],
                [
                    'id' => '904',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Purnia',

                ],
                [
                    'id' => '905',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Rohtas',

                ],
                [
                    'id' => '906',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Saharsa',

                ],
                [
                    'id' => '907',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Samastipur',

                ],
                [
                    'id' => '908',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Saran',

                ],
                [
                    'id' => '909',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Sheikhpura',

                ],
                [
                    'id' => '910',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Sheohar',

                ],
                [
                    'id' => '911',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Sitamarhi',

                ],
                [
                    'id' => '912',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Siwan',

                ],
                [
                    'id' => '913',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Supaul',

                ],
                [
                    'id' => '914',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'Vaishali',

                ],
                [
                    'id' => '915',
                    'country_id' => '78',
                    'division_id' => '12',
                    'name' => 'West Champaran',

                ],
                [
                    'id' => '916',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Balod',

                ],
                [
                    'id' => '917',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Baloda Bazar',

                ],
                [
                    'id' => '918',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Balrampur Ramanujganj',

                ],
                [
                    'id' => '919',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Bastar',

                ],
                [
                    'id' => '920',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Bemetara',

                ],
                [
                    'id' => '921',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Bijapur',

                ],
                [
                    'id' => '922',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Bilaspur',

                ],
                [
                    'id' => '923',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Dantewada',

                ],
                [
                    'id' => '924',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Dhamtari',

                ],
                [
                    'id' => '925',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Durg',

                ],
                [
                    'id' => '926',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Gariaband',

                ],
                [
                    'id' => '927',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Gaurela Pendra Marwahi',

                ],
                [
                    'id' => '928',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Janjgir Champa',

                ],
                [
                    'id' => '929',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Jashpur',

                ],
                [
                    'id' => '930',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Kabirdham',

                ],
                [
                    'id' => '931',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Kanker',

                ],
                [
                    'id' => '932',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Kondagaon',

                ],
                [
                    'id' => '933',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Korba',

                ],
                [
                    'id' => '934',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Koriya',

                ],
                [
                    'id' => '935',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Mahasamund',

                ],
                [
                    'id' => '936',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Mungeli',

                ],
                [
                    'id' => '937',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Narayanpur',

                ],
                [
                    'id' => '938',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Raigarh',

                ],
                [
                    'id' => '939',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Raipur',

                ],
                [
                    'id' => '940',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Rajnandgaon',

                ],
                [
                    'id' => '941',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Sukma',

                ],
                [
                    'id' => '942',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Surajpur',

                ],
                [
                    'id' => '943',
                    'country_id' => '78',
                    'division_id' => '13',
                    'name' => 'Surguja',

                ],
                [
                    'id' => '944',
                    'country_id' => '78',
                    'division_id' => '14',
                    'name' => 'North Goa',

                ],
                [
                    'id' => '945',
                    'country_id' => '78',
                    'division_id' => '14',
                    'name' => 'South Goa',

                ],
                [
                    'id' => '946',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Ahmedabad',

                ],
                [
                    'id' => '947',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Amreli',

                ],
                [
                    'id' => '948',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Anand',

                ],
                [
                    'id' => '949',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Aravalli',

                ],
                [
                    'id' => '950',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Banaskantha',

                ],
                [
                    'id' => '951',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Bharuch',

                ],
                [
                    'id' => '952',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Bhavnagar',

                ],
                [
                    'id' => '953',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Botad',

                ],
                [
                    'id' => '954',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Chhota Udaipur',

                ],
                [
                    'id' => '955',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Dahod',

                ],
                [
                    'id' => '956',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Dang',

                ],
                [
                    'id' => '957',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Devbhoomi Dwarka',

                ],
                [
                    'id' => '958',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Gandhinagar',

                ],
                [
                    'id' => '959',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Gir Somnath',

                ],
                [
                    'id' => '960',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Jamnagar',

                ],
                [
                    'id' => '961',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Junagadh',

                ],
                [
                    'id' => '962',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Kheda',

                ],
                [
                    'id' => '963',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Kutch',

                ],
                [
                    'id' => '964',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Mahisagar',

                ],
                [
                    'id' => '965',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Mehsana',

                ],
                [
                    'id' => '966',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Morbi',

                ],
                [
                    'id' => '967',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Narmada',

                ],
                [
                    'id' => '968',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Navsari',

                ],
                [
                    'id' => '969',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Panchmahal',

                ],
                [
                    'id' => '970',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Patan',

                ],
                [
                    'id' => '971',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Porbandar',

                ],
                [
                    'id' => '972',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Rajkot',

                ],
                [
                    'id' => '973',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Sabarkantha',

                ],
                [
                    'id' => '974',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Surat',

                ],
                [
                    'id' => '975',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Surendranagar',

                ],
                [
                    'id' => '976',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Tapi',

                ],
                [
                    'id' => '977',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Vadodara',

                ],
                [
                    'id' => '978',
                    'country_id' => '78',
                    'division_id' => '15',
                    'name' => 'Valsad',

                ],
                [
                    'id' => '979',
                    'country_id' => '78',
                    'division_id' => '16',
                    'name' => 'Ambala',

                ],
                [
                    'id' => '980',
                    'country_id' => '78',
                    'division_id' => '16',
                    'name' => 'Bhiwani',

                ],
                [
                    'id' => '981',
                    'country_id' => '78',
                    'division_id' => '16',
                    'name' => 'Charkhi Dadri',

                ],
                [
                    'id' => '982',
                    'country_id' => '78',
                    'division_id' => '16',
                    'name' => 'Faridabad',

                ],
                [
                    'id' => '983',
                    'country_id' => '78',
                    'division_id' => '16',
                    'name' => 'Fatehabad',

                ],
                [
                    'id' => '984',
                    'country_id' => '78',
                    'division_id' => '16',
                    'name' => 'Gurugram',

                ],
                [
                    'id' => '985',
                    'country_id' => '78',
                    'division_id' => '16',
                    'name' => 'Hisar',

                ],
                [
                    'id' => '986',
                    'country_id' => '78',
                    'division_id' => '16',
                    'name' => 'Jhajjar',

                ],
                [
                    'id' => '987',
                    'country_id' => '78',
                    'division_id' => '16',
                    'name' => 'Jind',

                ],
                [
                    'id' => '988',
                    'country_id' => '78',
                    'division_id' => '16',
                    'name' => 'Kaithal',

                ],
                [
                    'id' => '989',
                    'country_id' => '78',
                    'division_id' => '16',
                    'name' => 'Karnal',

                ],
                [
                    'id' => '990',
                    'country_id' => '78',
                    'division_id' => '16',
                    'name' => 'Kurukshetra',

                ],
                [
                    'id' => '991',
                    'country_id' => '78',
                    'division_id' => '16',
                    'name' => 'Mahendragarh',

                ],
                [
                    'id' => '992',
                    'country_id' => '78',
                    'division_id' => '16',
                    'name' => 'Mewat',

                ],
                [
                    'id' => '993',
                    'country_id' => '78',
                    'division_id' => '16',
                    'name' => 'Palwal',

                ],
                [
                    'id' => '994',
                    'country_id' => '78',
                    'division_id' => '16',
                    'name' => 'Panchkula',

                ],
                [
                    'id' => '995',
                    'country_id' => '78',
                    'division_id' => '16',
                    'name' => 'Panipat',

                ],
                [
                    'id' => '996',
                    'country_id' => '78',
                    'division_id' => '16',
                    'name' => 'Rewari',

                ],
                [
                    'id' => '997',
                    'country_id' => '78',
                    'division_id' => '16',
                    'name' => 'Rohtak',

                ],
                [
                    'id' => '998',
                    'country_id' => '78',
                    'division_id' => '16',
                    'name' => 'Sirsa',

                ],
                [
                    'id' => '999',
                    'country_id' => '78',
                    'division_id' => '16',
                    'name' => 'Sonipat',

                ],
                [
                    'id' => '1000',
                    'country_id' => '78',
                    'division_id' => '16',
                    'name' => 'Yamunanagar',

                ],
                [
                    'id' => '1001',
                    'country_id' => '78',
                    'division_id' => '17',
                    'name' => 'Bilaspur',

                ],
                [
                    'id' => '1002',
                    'country_id' => '78',
                    'division_id' => '17',
                    'name' => 'Chamba',

                ],
                [
                    'id' => '1003',
                    'country_id' => '78',
                    'division_id' => '17',
                    'name' => 'Hamirpur',

                ],
                [
                    'id' => '1004',
                    'country_id' => '78',
                    'division_id' => '17',
                    'name' => 'Kangra',

                ],
                [
                    'id' => '1005',
                    'country_id' => '78',
                    'division_id' => '17',
                    'name' => 'Kinnaur',

                ],
                [
                    'id' => '1006',
                    'country_id' => '78',
                    'division_id' => '17',
                    'name' => 'Kullu',

                ],
                [
                    'id' => '1007',
                    'country_id' => '78',
                    'division_id' => '17',
                    'name' => 'Lahaul Spiti',

                ],
                [
                    'id' => '1008',
                    'country_id' => '78',
                    'division_id' => '17',
                    'name' => 'Mandi',

                ],
                [
                    'id' => '1009',
                    'country_id' => '78',
                    'division_id' => '17',
                    'name' => 'Shimla',

                ],
                [
                    'id' => '1010',
                    'country_id' => '78',
                    'division_id' => '17',
                    'name' => 'Sirmaur',

                ],
                [
                    'id' => '1011',
                    'country_id' => '78',
                    'division_id' => '17',
                    'name' => 'Solan',

                ],
                [
                    'id' => '1012',
                    'country_id' => '78',
                    'division_id' => '17',
                    'name' => 'Una',

                ],
                [
                    'id' => '1013',
                    'country_id' => '78',
                    'division_id' => '18',
                    'name' => 'Anantnag',

                ],
                [
                    'id' => '1014',
                    'country_id' => '78',
                    'division_id' => '18',
                    'name' => 'Bandipora',

                ],
                [
                    'id' => '1015',
                    'country_id' => '78',
                    'division_id' => '18',
                    'name' => 'Baramulla',

                ],
                [
                    'id' => '1016',
                    'country_id' => '78',
                    'division_id' => '18',
                    'name' => 'Budgam',

                ],
                [
                    'id' => '1017',
                    'country_id' => '78',
                    'division_id' => '18',
                    'name' => 'Doda',

                ],
                [
                    'id' => '1018',
                    'country_id' => '78',
                    'division_id' => '18',
                    'name' => 'Ganderbal',

                ],
                [
                    'id' => '1019',
                    'country_id' => '78',
                    'division_id' => '18',
                    'name' => 'Jammu',

                ],
                [
                    'id' => '1020',
                    'country_id' => '78',
                    'division_id' => '18',
                    'name' => 'Kathua',

                ],
                [
                    'id' => '1021',
                    'country_id' => '78',
                    'division_id' => '18',
                    'name' => 'Kishtwar',

                ],
                [
                    'id' => '1022',
                    'country_id' => '78',
                    'division_id' => '18',
                    'name' => 'Kulgam',

                ],
                [
                    'id' => '1023',
                    'country_id' => '78',
                    'division_id' => '18',
                    'name' => 'Kupwara',

                ],
                [
                    'id' => '1024',
                    'country_id' => '78',
                    'division_id' => '18',
                    'name' => 'Poonch',

                ],
                [
                    'id' => '1025',
                    'country_id' => '78',
                    'division_id' => '18',
                    'name' => 'Pulwama',

                ],
                [
                    'id' => '1026',
                    'country_id' => '78',
                    'division_id' => '18',
                    'name' => 'Rajouri',

                ],
                [
                    'id' => '1027',
                    'country_id' => '78',
                    'division_id' => '18',
                    'name' => 'Ramban',

                ],
                [
                    'id' => '1028',
                    'country_id' => '78',
                    'division_id' => '18',
                    'name' => 'Reasi',

                ],
                [
                    'id' => '1029',
                    'country_id' => '78',
                    'division_id' => '18',
                    'name' => 'Samba',

                ],
                [
                    'id' => '1030',
                    'country_id' => '78',
                    'division_id' => '18',
                    'name' => 'Shopian',

                ],
                [
                    'id' => '1031',
                    'country_id' => '78',
                    'division_id' => '18',
                    'name' => 'Srinagar',

                ],
                [
                    'id' => '1032',
                    'country_id' => '78',
                    'division_id' => '18',
                    'name' => 'Udhampur',

                ],
                [
                    'id' => '1033',
                    'country_id' => '78',
                    'division_id' => '19',
                    'name' => 'Bokaro',

                ],
                [
                    'id' => '1034',
                    'country_id' => '78',
                    'division_id' => '19',
                    'name' => 'Chatra',

                ],
                [
                    'id' => '1035',
                    'country_id' => '78',
                    'division_id' => '19',
                    'name' => 'Deoghar',

                ],
                [
                    'id' => '1036',
                    'country_id' => '78',
                    'division_id' => '19',
                    'name' => 'Dhanbad',

                ],
                [
                    'id' => '1037',
                    'country_id' => '78',
                    'division_id' => '19',
                    'name' => 'Dumka',

                ],
                [
                    'id' => '1038',
                    'country_id' => '78',
                    'division_id' => '19',
                    'name' => 'East Singhbhum',

                ],
                [
                    'id' => '1039',
                    'country_id' => '78',
                    'division_id' => '19',
                    'name' => 'Garhwa',

                ],
                [
                    'id' => '1040',
                    'country_id' => '78',
                    'division_id' => '19',
                    'name' => 'Giridih',

                ],
                [
                    'id' => '1041',
                    'country_id' => '78',
                    'division_id' => '19',
                    'name' => 'Godda',

                ],
                [
                    'id' => '1042',
                    'country_id' => '78',
                    'division_id' => '19',
                    'name' => 'Gumla',

                ],
                [
                    'id' => '1043',
                    'country_id' => '78',
                    'division_id' => '19',
                    'name' => 'Hazaribagh',

                ],
                [
                    'id' => '1044',
                    'country_id' => '78',
                    'division_id' => '19',
                    'name' => 'Jamtara',

                ],
                [
                    'id' => '1045',
                    'country_id' => '78',
                    'division_id' => '19',
                    'name' => 'Khunti',

                ],
                [
                    'id' => '1046',
                    'country_id' => '78',
                    'division_id' => '19',
                    'name' => 'Koderma',

                ],
                [
                    'id' => '1047',
                    'country_id' => '78',
                    'division_id' => '19',
                    'name' => 'Latehar',

                ],
                [
                    'id' => '1048',
                    'country_id' => '78',
                    'division_id' => '19',
                    'name' => 'Lohardaga',

                ],
                [
                    'id' => '1049',
                    'country_id' => '78',
                    'division_id' => '19',
                    'name' => 'Pakur',

                ],
                [
                    'id' => '1050',
                    'country_id' => '78',
                    'division_id' => '19',
                    'name' => 'Palamu',

                ],
                [
                    'id' => '1051',
                    'country_id' => '78',
                    'division_id' => '19',
                    'name' => 'Ramgarh',

                ],
                [
                    'id' => '1052',
                    'country_id' => '78',
                    'division_id' => '19',
                    'name' => 'Ranchi',

                ],
                [
                    'id' => '1053',
                    'country_id' => '78',
                    'division_id' => '19',
                    'name' => 'Sahebganj',

                ],
                [
                    'id' => '1054',
                    'country_id' => '78',
                    'division_id' => '19',
                    'name' => 'Seraikela Kharsawan',

                ],
                [
                    'id' => '1055',
                    'country_id' => '78',
                    'division_id' => '19',
                    'name' => 'Simdega',

                ],
                [
                    'id' => '1056',
                    'country_id' => '78',
                    'division_id' => '19',
                    'name' => 'West Singhbhum',

                ],
                [
                    'id' => '1057',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Bagalkot',

                ],
                [
                    'id' => '1058',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Bangalore Rural',

                ],
                [
                    'id' => '1059',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Bangalore Urban',

                ],
                [
                    'id' => '1060',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Belgaum',

                ],
                [
                    'id' => '1061',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Bellary',

                ],
                [
                    'id' => '1062',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Bidar',

                ],
                [
                    'id' => '1063',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Chamarajanagar',

                ],
                [
                    'id' => '1064',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Chikkaballapur',

                ],
                [
                    'id' => '1065',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Chikkamagaluru',

                ],
                [
                    'id' => '1066',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Chitradurga',

                ],
                [
                    'id' => '1067',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Dakshina Kannada',

                ],
                [
                    'id' => '1068',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Davanagere',

                ],
                [
                    'id' => '1069',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Dharwad',

                ],
                [
                    'id' => '1070',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Gadag',

                ],
                [
                    'id' => '1071',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Gulbarga',

                ],
                [
                    'id' => '1072',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Hassan',

                ],
                [
                    'id' => '1073',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Haveri',

                ],
                [
                    'id' => '1074',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Kodagu',

                ],
                [
                    'id' => '1075',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Kolar',

                ],
                [
                    'id' => '1076',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Koppal',

                ],
                [
                    'id' => '1077',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Mandya',

                ],
                [
                    'id' => '1078',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Mysore',

                ],
                [
                    'id' => '1079',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Raichur',

                ],
                [
                    'id' => '1080',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Ramanagara',

                ],
                [
                    'id' => '1081',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Shimoga',

                ],
                [
                    'id' => '1082',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Tumkur',

                ],
                [
                    'id' => '1083',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Udupi',

                ],
                [
                    'id' => '1084',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Uttara Kannada',

                ],
                [
                    'id' => '1085',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Vijayanagara',

                ],
                [
                    'id' => '1086',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Vijayapura',

                ],
                [
                    'id' => '1087',
                    'country_id' => '78',
                    'division_id' => '20',
                    'name' => 'Yadgir',

                ],
                [
                    'id' => '1088',
                    'country_id' => '78',
                    'division_id' => '21',
                    'name' => 'Alappuzha',

                ],
                [
                    'id' => '1089',
                    'country_id' => '78',
                    'division_id' => '21',
                    'name' => 'Ernakulam',

                ],
                [
                    'id' => '1090',
                    'country_id' => '78',
                    'division_id' => '21',
                    'name' => 'Idukki',

                ],
                [
                    'id' => '1091',
                    'country_id' => '78',
                    'division_id' => '21',
                    'name' => 'Kannur',

                ],
                [
                    'id' => '1092',
                    'country_id' => '78',
                    'division_id' => '21',
                    'name' => 'Kasaragod',

                ],
                [
                    'id' => '1093',
                    'country_id' => '78',
                    'division_id' => '21',
                    'name' => 'Kollam',

                ],
                [
                    'id' => '1094',
                    'country_id' => '78',
                    'division_id' => '21',
                    'name' => 'Kottayam',

                ],
                [
                    'id' => '1095',
                    'country_id' => '78',
                    'division_id' => '21',
                    'name' => 'Kozhikode',

                ],
                [
                    'id' => '1096',
                    'country_id' => '78',
                    'division_id' => '21',
                    'name' => 'Malappuram',

                ],
                [
                    'id' => '1097',
                    'country_id' => '78',
                    'division_id' => '21',
                    'name' => 'Palakkad',

                ],
                [
                    'id' => '1098',
                    'country_id' => '78',
                    'division_id' => '21',
                    'name' => 'Pathanamthitta',

                ],
                [
                    'id' => '1099',
                    'country_id' => '78',
                    'division_id' => '21',
                    'name' => 'Thiruvananthapuram',

                ],
                [
                    'id' => '1100',
                    'country_id' => '78',
                    'division_id' => '21',
                    'name' => 'Thrissur',

                ],
                [
                    'id' => '1101',
                    'country_id' => '78',
                    'division_id' => '21',
                    'name' => 'Wayanad',

                ],
                [
                    'id' => '1102',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Agar Malwa',

                ],
                [
                    'id' => '1103',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Alirajpur',

                ],
                [
                    'id' => '1104',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Anuppur',

                ],
                [
                    'id' => '1105',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Ashoknagar',

                ],
                [
                    'id' => '1106',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Balaghat',

                ],
                [
                    'id' => '1107',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Barwani',

                ],
                [
                    'id' => '1108',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Betul',

                ],
                [
                    'id' => '1109',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Bhind',

                ],
                [
                    'id' => '1110',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Bhopal',

                ],
                [
                    'id' => '1111',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Burhanpur',

                ],
                [
                    'id' => '1112',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Chachaura',

                ],
                [
                    'id' => '1113',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Chhatarpur',

                ],
                [
                    'id' => '1114',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Chhindwara',

                ],
                [
                    'id' => '1115',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Damoh',

                ],
                [
                    'id' => '1116',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Datia',

                ],
                [
                    'id' => '1117',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Dewas',

                ],
                [
                    'id' => '1118',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Dhar',

                ],
                [
                    'id' => '1119',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Dindori',

                ],
                [
                    'id' => '1120',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Guna',

                ],
                [
                    'id' => '1121',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Gwalior',

                ],
                [
                    'id' => '1122',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Harda',

                ],
                [
                    'id' => '1123',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Hoshangabad',

                ],
                [
                    'id' => '1124',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Indore',

                ],
                [
                    'id' => '1125',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Jabalpur',

                ],
                [
                    'id' => '1126',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Jhabua',

                ],
                [
                    'id' => '1127',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Katni',

                ],
                [
                    'id' => '1128',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Khandwa',

                ],
                [
                    'id' => '1129',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Khargone',

                ],
                [
                    'id' => '1130',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Maihar',

                ],
                [
                    'id' => '1131',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Mandla',

                ],
                [
                    'id' => '1132',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Mandsaur',

                ],
                [
                    'id' => '1133',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Morena',

                ],
                [
                    'id' => '1134',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Nagda',

                ],
                [
                    'id' => '1135',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Narsinghpur',

                ],
                [
                    'id' => '1136',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Neemuch',

                ],
                [
                    'id' => '1137',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Niwari',

                ],
                [
                    'id' => '1138',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Panna',

                ],
                [
                    'id' => '1139',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Raisen',

                ],
                [
                    'id' => '1140',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Rajgarh',

                ],
                [
                    'id' => '1141',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Ratlam',

                ],
                [
                    'id' => '1142',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Rewa',

                ],
                [
                    'id' => '1143',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Sagar',

                ],
                [
                    'id' => '1144',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Satna',

                ],
                [
                    'id' => '1145',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Sehore',

                ],
                [
                    'id' => '1146',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Seoni',

                ],
                [
                    'id' => '1147',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Shahdol',

                ],
                [
                    'id' => '1148',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Shajapur',

                ],
                [
                    'id' => '1149',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Sheopur',

                ],
                [
                    'id' => '1150',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Shivpuri',

                ],
                [
                    'id' => '1151',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Sidhi',

                ],
                [
                    'id' => '1152',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Singrauli',

                ],
                [
                    'id' => '1153',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Tikamgarh',

                ],
                [
                    'id' => '1154',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Ujjain',

                ],
                [
                    'id' => '1155',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Umaria',

                ],
                [
                    'id' => '1156',
                    'country_id' => '78',
                    'division_id' => '22',
                    'name' => 'Vidisha',

                ],
                [
                    'id' => '1157',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Ahmednagar',

                ],
                [
                    'id' => '1158',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Akola',

                ],
                [
                    'id' => '1159',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Amravati',

                ],
                [
                    'id' => '1160',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Aurangabad',

                ],
                [
                    'id' => '1161',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Beed',

                ],
                [
                    'id' => '1162',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Bhandara',

                ],
                [
                    'id' => '1163',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Buldhana',

                ],
                [
                    'id' => '1164',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Chandrapur',

                ],
                [
                    'id' => '1165',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Dhule',

                ],
                [
                    'id' => '1166',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Gadchiroli',

                ],
                [
                    'id' => '1167',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Gondia',

                ],
                [
                    'id' => '1168',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Hingoli',

                ],
                [
                    'id' => '1169',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Jalgaon',

                ],
                [
                    'id' => '1170',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Jalna',

                ],
                [
                    'id' => '1171',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Kolhapur',

                ],
                [
                    'id' => '1172',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Latur',

                ],
                [
                    'id' => '1173',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Mumbai City',

                ],
                [
                    'id' => '1174',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Mumbai Suburban',

                ],
                [
                    'id' => '1175',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Nagpur',

                ],
                [
                    'id' => '1176',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Nanded',

                ],
                [
                    'id' => '1177',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Nandurbar',

                ],
                [
                    'id' => '1178',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Nashik',

                ],
                [
                    'id' => '1179',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Osmanabad',

                ],
                [
                    'id' => '1180',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Palghar',

                ],
                [
                    'id' => '1181',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Parbhani',

                ],
                [
                    'id' => '1182',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Pune',

                ],
                [
                    'id' => '1183',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Raigad',

                ],
                [
                    'id' => '1184',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Ratnagiri',

                ],
                [
                    'id' => '1185',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Sangli',

                ],
                [
                    'id' => '1186',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Satara',

                ],
                [
                    'id' => '1187',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Sindhudurg',

                ],
                [
                    'id' => '1188',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Solapur',

                ],
                [
                    'id' => '1189',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Thane',

                ],
                [
                    'id' => '1190',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Wardha',

                ],
                [
                    'id' => '1191',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Washim',

                ],
                [
                    'id' => '1192',
                    'country_id' => '78',
                    'division_id' => '23',
                    'name' => 'Yavatmal',

                ],
                [
                    'id' => '1193',
                    'country_id' => '78',
                    'division_id' => '24',
                    'name' => 'Bishnupur',

                ],
                [
                    'id' => '1194',
                    'country_id' => '78',
                    'division_id' => '24',
                    'name' => 'Chandel',

                ],
                [
                    'id' => '1195',
                    'country_id' => '78',
                    'division_id' => '24',
                    'name' => 'Churachandpur',

                ],
                [
                    'id' => '1196',
                    'country_id' => '78',
                    'division_id' => '24',
                    'name' => 'Imphal East',

                ],
                [
                    'id' => '1197',
                    'country_id' => '78',
                    'division_id' => '24',
                    'name' => 'Imphal West',

                ],
                [
                    'id' => '1198',
                    'country_id' => '78',
                    'division_id' => '24',
                    'name' => 'Jiribam',

                ],
                [
                    'id' => '1199',
                    'country_id' => '78',
                    'division_id' => '24',
                    'name' => 'Kakching',

                ],
                [
                    'id' => '1200',
                    'country_id' => '78',
                    'division_id' => '24',
                    'name' => 'Kamjong',

                ],
                [
                    'id' => '1201',
                    'country_id' => '78',
                    'division_id' => '24',
                    'name' => 'Kangpokpi',

                ],
                [
                    'id' => '1202',
                    'country_id' => '78',
                    'division_id' => '24',
                    'name' => 'Noney',

                ],
                [
                    'id' => '1203',
                    'country_id' => '78',
                    'division_id' => '24',
                    'name' => 'Pherzawl',

                ],
                [
                    'id' => '1204',
                    'country_id' => '78',
                    'division_id' => '24',
                    'name' => 'Senapati',

                ],
                [
                    'id' => '1205',
                    'country_id' => '78',
                    'division_id' => '24',
                    'name' => 'Tamenglong',

                ],
                [
                    'id' => '1206',
                    'country_id' => '78',
                    'division_id' => '24',
                    'name' => 'Tengnoupal',

                ],
                [
                    'id' => '1207',
                    'country_id' => '78',
                    'division_id' => '24',
                    'name' => 'Thoubal',

                ],
                [
                    'id' => '1208',
                    'country_id' => '78',
                    'division_id' => '24',
                    'name' => 'Ukhrul',

                ],
                [
                    'id' => '1209',
                    'country_id' => '78',
                    'division_id' => '25',
                    'name' => 'East Garo Hills',

                ],
                [
                    'id' => '1210',
                    'country_id' => '78',
                    'division_id' => '25',
                    'name' => 'East Jaintia Hills',

                ],
                [
                    'id' => '1211',
                    'country_id' => '78',
                    'division_id' => '25',
                    'name' => 'East Khasi Hills',

                ],
                [
                    'id' => '1212',
                    'country_id' => '78',
                    'division_id' => '25',
                    'name' => 'North Garo Hills',

                ],
                [
                    'id' => '1213',
                    'country_id' => '78',
                    'division_id' => '25',
                    'name' => 'Ri Bhoi',

                ],
                [
                    'id' => '1214',
                    'country_id' => '78',
                    'division_id' => '25',
                    'name' => 'South Garo Hills',

                ],
                [
                    'id' => '1215',
                    'country_id' => '78',
                    'division_id' => '25',
                    'name' => 'South West Garo Hills',

                ],
                [
                    'id' => '1216',
                    'country_id' => '78',
                    'division_id' => '25',
                    'name' => 'South West Khasi Hills',

                ],
                [
                    'id' => '1217',
                    'country_id' => '78',
                    'division_id' => '25',
                    'name' => 'West Garo Hills',

                ],
                [
                    'id' => '1218',
                    'country_id' => '78',
                    'division_id' => '25',
                    'name' => 'West Jaintia Hills',

                ],
                [
                    'id' => '1219',
                    'country_id' => '78',
                    'division_id' => '25',
                    'name' => 'West Khasi Hills',

                ],
                [
                    'id' => '1220',
                    'country_id' => '78',
                    'division_id' => '26',
                    'name' => 'Aizawl',

                ],
                [
                    'id' => '1221',
                    'country_id' => '78',
                    'division_id' => '26',
                    'name' => 'Champhai',

                ],
                [
                    'id' => '1222',
                    'country_id' => '78',
                    'division_id' => '26',
                    'name' => 'Hnahthial',

                ],
                [
                    'id' => '1223',
                    'country_id' => '78',
                    'division_id' => '26',
                    'name' => 'Khawzawl',

                ],
                [
                    'id' => '1224',
                    'country_id' => '78',
                    'division_id' => '26',
                    'name' => 'Kolasib',

                ],
                [
                    'id' => '1225',
                    'country_id' => '78',
                    'division_id' => '26',
                    'name' => 'Lawngtlai',

                ],
                [
                    'id' => '1226',
                    'country_id' => '78',
                    'division_id' => '26',
                    'name' => 'Lunglei',

                ],
                [
                    'id' => '1227',
                    'country_id' => '78',
                    'division_id' => '26',
                    'name' => 'Mamit',

                ],
                [
                    'id' => '1228',
                    'country_id' => '78',
                    'division_id' => '26',
                    'name' => 'Saiha',

                ],
                [
                    'id' => '1229',
                    'country_id' => '78',
                    'division_id' => '26',
                    'name' => 'Saitual',

                ],
                [
                    'id' => '1230',
                    'country_id' => '78',
                    'division_id' => '26',
                    'name' => 'Serchhip',

                ],
                [
                    'id' => '1231',
                    'country_id' => '78',
                    'division_id' => '27',
                    'name' => 'Mon',

                ],
                [
                    'id' => '1232',
                    'country_id' => '78',
                    'division_id' => '27',
                    'name' => 'Dimapur',

                ],
                [
                    'id' => '1233',
                    'country_id' => '78',
                    'division_id' => '27',
                    'name' => 'Kiphire',

                ],
                [
                    'id' => '1234',
                    'country_id' => '78',
                    'division_id' => '27',
                    'name' => 'Kohima',

                ],
                [
                    'id' => '1235',
                    'country_id' => '78',
                    'division_id' => '27',
                    'name' => 'Longleng',

                ],
                [
                    'id' => '1236',
                    'country_id' => '78',
                    'division_id' => '27',
                    'name' => 'Mokokchung',

                ],
                [
                    'id' => '1237',
                    'country_id' => '78',
                    'division_id' => '27',
                    'name' => 'Noklak',

                ],
                [
                    'id' => '1238',
                    'country_id' => '78',
                    'division_id' => '27',
                    'name' => 'Peren',

                ],
                [
                    'id' => '1239',
                    'country_id' => '78',
                    'division_id' => '27',
                    'name' => 'Phek',

                ],
                [
                    'id' => '1240',
                    'country_id' => '78',
                    'division_id' => '27',
                    'name' => 'Tuensang',

                ],
                [
                    'id' => '1241',
                    'country_id' => '78',
                    'division_id' => '27',
                    'name' => 'Wokha',

                ],
                [
                    'id' => '1242',
                    'country_id' => '78',
                    'division_id' => '27',
                    'name' => 'Zunheboto',

                ],
                [
                    'id' => '1243',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Angul',

                ],
                [
                    'id' => '1244',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Balangir',

                ],
                [
                    'id' => '1245',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Balasore',

                ],
                [
                    'id' => '1246',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Bargarh',

                ],
                [
                    'id' => '1247',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Bhadrak',

                ],
                [
                    'id' => '1248',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Boudh',

                ],
                [
                    'id' => '1249',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Cuttack',

                ],
                [
                    'id' => '1250',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Debagarh',

                ],
                [
                    'id' => '1251',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Dhenkanal',

                ],
                [
                    'id' => '1252',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Gajapati',

                ],
                [
                    'id' => '1253',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Ganjam',

                ],
                [
                    'id' => '1254',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Jagatsinghpur',

                ],
                [
                    'id' => '1255',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Jajpur',

                ],
                [
                    'id' => '1256',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Jharsuguda',

                ],
                [
                    'id' => '1257',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Kalahandi',

                ],
                [
                    'id' => '1258',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Kandhamal',

                ],
                [
                    'id' => '1259',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Kendrapara',

                ],
                [
                    'id' => '1260',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Kendujhar',

                ],
                [
                    'id' => '1261',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Khordha',

                ],
                [
                    'id' => '1262',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Koraput',

                ],
                [
                    'id' => '1263',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Malkangiri',

                ],
                [
                    'id' => '1264',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Mayurbhanj',

                ],
                [
                    'id' => '1265',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Nabarangpur',

                ],
                [
                    'id' => '1266',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Nayagarh',

                ],
                [
                    'id' => '1267',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Nuapada',

                ],
                [
                    'id' => '1268',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Puri',

                ],
                [
                    'id' => '1269',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Rayagada',

                ],
                [
                    'id' => '1270',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Sambalpur',

                ],
                [
                    'id' => '1271',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Subarnapur',

                ],
                [
                    'id' => '1272',
                    'country_id' => '78',
                    'division_id' => '28',
                    'name' => 'Sundergarh',

                ],
                [
                    'id' => '1273',
                    'country_id' => '78',
                    'division_id' => '29',
                    'name' => 'Amritsar',

                ],
                [
                    'id' => '1274',
                    'country_id' => '78',
                    'division_id' => '29',
                    'name' => 'Barnala',

                ],
                [
                    'id' => '1275',
                    'country_id' => '78',
                    'division_id' => '29',
                    'name' => 'Bathinda',

                ],
                [
                    'id' => '1276',
                    'country_id' => '78',
                    'division_id' => '29',
                    'name' => 'Faridkot',

                ],
                [
                    'id' => '1277',
                    'country_id' => '78',
                    'division_id' => '29',
                    'name' => 'Fatehgarh Sahib',

                ],
                [
                    'id' => '1278',
                    'country_id' => '78',
                    'division_id' => '29',
                    'name' => 'Fazilka',

                ],
                [
                    'id' => '1279',
                    'country_id' => '78',
                    'division_id' => '29',
                    'name' => 'Firozpur',

                ],
                [
                    'id' => '1280',
                    'country_id' => '78',
                    'division_id' => '29',
                    'name' => 'Gurdaspur',

                ],
                [
                    'id' => '1281',
                    'country_id' => '78',
                    'division_id' => '29',
                    'name' => 'Hoshiarpur',

                ],
                [
                    'id' => '1282',
                    'country_id' => '78',
                    'division_id' => '29',
                    'name' => 'Jalandhar',

                ],
                [
                    'id' => '1283',
                    'country_id' => '78',
                    'division_id' => '29',
                    'name' => 'Kapurthala',

                ],
                [
                    'id' => '1284',
                    'country_id' => '78',
                    'division_id' => '29',
                    'name' => 'Ludhiana',

                ],
                [
                    'id' => '1285',
                    'country_id' => '78',
                    'division_id' => '29',
                    'name' => 'Mansa',

                ],
                [
                    'id' => '1286',
                    'country_id' => '78',
                    'division_id' => '29',
                    'name' => 'Moga',

                ],
                [
                    'id' => '1287',
                    'country_id' => '78',
                    'division_id' => '29',
                    'name' => 'Mohali',

                ],
                [
                    'id' => '1288',
                    'country_id' => '78',
                    'division_id' => '29',
                    'name' => 'Muktsar',

                ],
                [
                    'id' => '1289',
                    'country_id' => '78',
                    'division_id' => '29',
                    'name' => 'Pathankot',

                ],
                [
                    'id' => '1290',
                    'country_id' => '78',
                    'division_id' => '29',
                    'name' => 'Patiala',

                ],
                [
                    'id' => '1291',
                    'country_id' => '78',
                    'division_id' => '29',
                    'name' => 'Rupnagar',

                ],
                [
                    'id' => '1292',
                    'country_id' => '78',
                    'division_id' => '29',
                    'name' => 'Sangrur',

                ],
                [
                    'id' => '1293',
                    'country_id' => '78',
                    'division_id' => '29',
                    'name' => 'Shaheed Bhagat Singh Nagar',

                ],
                [
                    'id' => '1294',
                    'country_id' => '78',
                    'division_id' => '29',
                    'name' => 'Tarn Taran',

                ],
                [
                    'id' => '1295',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Ajmer',

                ],
                [
                    'id' => '1296',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Alwar',

                ],
                [
                    'id' => '1297',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Banswara',

                ],
                [
                    'id' => '1298',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Baran',

                ],
                [
                    'id' => '1299',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Barmer',

                ],
                [
                    'id' => '1300',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Bharatpur',

                ],
                [
                    'id' => '1301',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Bhilwara',

                ],
                [
                    'id' => '1302',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Bikaner',

                ],
                [
                    'id' => '1303',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Bundi',

                ],
                [
                    'id' => '1304',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Chittorgarh',

                ],
                [
                    'id' => '1305',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Churu',

                ],
                [
                    'id' => '1306',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Dausa',

                ],
                [
                    'id' => '1307',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Dholpur',

                ],
                [
                    'id' => '1308',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Dungarpur',

                ],
                [
                    'id' => '1309',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Sri Ganganagar',

                ],
                [
                    'id' => '1310',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Hanumangarh',

                ],
                [
                    'id' => '1311',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Jaipur',

                ],
                [
                    'id' => '1312',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Jaisalmer',

                ],
                [
                    'id' => '1313',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Jalore',

                ],
                [
                    'id' => '1314',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Jhalawar',

                ],
                [
                    'id' => '1315',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Jhunjhunu',

                ],
                [
                    'id' => '1316',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Jodhpur',

                ],
                [
                    'id' => '1317',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Karauli',

                ],
                [
                    'id' => '1318',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Kota',

                ],
                [
                    'id' => '1319',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Nagaur',

                ],
                [
                    'id' => '1320',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Pali',

                ],
                [
                    'id' => '1321',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Pratapgarh',

                ],
                [
                    'id' => '1322',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Rajsamand',

                ],
                [
                    'id' => '1323',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Sawai Madhopur',

                ],
                [
                    'id' => '1324',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Sikar',

                ],
                [
                    'id' => '1325',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Sirohi',

                ],
                [
                    'id' => '1326',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Tonk',

                ],
                [
                    'id' => '1327',
                    'country_id' => '78',
                    'division_id' => '30',
                    'name' => 'Udaipur',

                ],
                [
                    'id' => '1328',
                    'country_id' => '78',
                    'division_id' => '31',
                    'name' => 'East Sikkim',

                ],
                [
                    'id' => '1329',
                    'country_id' => '78',
                    'division_id' => '31',
                    'name' => 'North Sikkim',

                ],
                [
                    'id' => '1330',
                    'country_id' => '78',
                    'division_id' => '31',
                    'name' => 'South Sikkim',

                ],
                [
                    'id' => '1331',
                    'country_id' => '78',
                    'division_id' => '31',
                    'name' => 'West Sikkim',

                ],
                [
                    'id' => '1332',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Ariyalur',

                ],
                [
                    'id' => '1333',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Chengalpattu',

                ],
                [
                    'id' => '1334',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Chennai',

                ],
                [
                    'id' => '1335',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Coimbatore',

                ],
                [
                    'id' => '1336',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Cuddalore',

                ],
                [
                    'id' => '1337',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Dharmapuri',

                ],
                [
                    'id' => '1338',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Dindigul',

                ],
                [
                    'id' => '1339',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Erode',

                ],
                [
                    'id' => '1340',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Kallakurichi',

                ],
                [
                    'id' => '1341',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Kanchipuram',

                ],
                [
                    'id' => '1342',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Kanyakumari',

                ],
                [
                    'id' => '1343',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Karur',

                ],
                [
                    'id' => '1344',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Krishnagiri',

                ],
                [
                    'id' => '1345',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Madurai',

                ],
                [
                    'id' => '1346',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Mayiladuthurai',

                ],
                [
                    'id' => '1347',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Nagapattinam',

                ],
                [
                    'id' => '1348',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Namakkal',

                ],
                [
                    'id' => '1349',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Nilgiris',

                ],
                [
                    'id' => '1350',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Perambalur',

                ],
                [
                    'id' => '1351',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Pudukkottai',

                ],
                [
                    'id' => '1352',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Ramanathapuram',

                ],
                [
                    'id' => '1353',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Ranipet',

                ],
                [
                    'id' => '1354',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Salem',

                ],
                [
                    'id' => '1355',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Sivaganga',

                ],
                [
                    'id' => '1356',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Tenkasi',

                ],
                [
                    'id' => '1357',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Thanjavur',

                ],
                [
                    'id' => '1358',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Theni',

                ],
                [
                    'id' => '1359',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Thoothukudi',

                ],
                [
                    'id' => '1360',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Tiruchirappalli',

                ],
                [
                    'id' => '1361',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Tirunelveli',

                ],
                [
                    'id' => '1362',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Tirupattur',

                ],
                [
                    'id' => '1363',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Tiruppur',

                ],
                [
                    'id' => '1364',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Tiruvallur',

                ],
                [
                    'id' => '1365',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Tiruvannamalai',

                ],
                [
                    'id' => '1366',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Tiruvarur',

                ],
                [
                    'id' => '1367',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Vellore',

                ],
                [
                    'id' => '1368',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Viluppuram',

                ],
                [
                    'id' => '1369',
                    'country_id' => '78',
                    'division_id' => '32',
                    'name' => 'Virudhunagar',

                ],
                [
                    'id' => '1370',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Adilabad',

                ],
                [
                    'id' => '1371',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Bhadradri Kothagudem',

                ],
                [
                    'id' => '1372',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Hyderabad',

                ],
                [
                    'id' => '1373',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Jagtial',

                ],
                [
                    'id' => '1374',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Jangaon',

                ],
                [
                    'id' => '1375',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Jayashankar Bhupalpally',

                ],
                [
                    'id' => '1376',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Jogulamba Gadwal',

                ],
                [
                    'id' => '1377',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Kamareddy',

                ],
                [
                    'id' => '1378',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Karimnagar',

                ],
                [
                    'id' => '1379',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Khammam',

                ],
                [
                    'id' => '1380',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Komaram Bheem',

                ],
                [
                    'id' => '1381',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Mahabubabad',

                ],
                [
                    'id' => '1382',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Mahbubnagar',

                ],
                [
                    'id' => '1383',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Mancherial',

                ],
                [
                    'id' => '1384',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Medak',

                ],
                [
                    'id' => '1385',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Medchal',

                ],
                [
                    'id' => '1386',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Mulugu',

                ],
                [
                    'id' => '1387',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Nagarkurnool',

                ],
                [
                    'id' => '1388',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Nalgonda',

                ],
                [
                    'id' => '1389',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Narayanpet',

                ],
                [
                    'id' => '1390',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Nirmal',

                ],
                [
                    'id' => '1391',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Nizamabad',

                ],
                [
                    'id' => '1392',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Peddapalli',

                ],
                [
                    'id' => '1393',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Rajanna Sircilla',

                ],
                [
                    'id' => '1394',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Ranga Reddy',

                ],
                [
                    'id' => '1395',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Sangareddy',

                ],
                [
                    'id' => '1396',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Siddipet',

                ],
                [
                    'id' => '1397',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Suryapet',

                ],
                [
                    'id' => '1398',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Vikarabad',

                ],
                [
                    'id' => '1399',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Wanaparthy',

                ],
                [
                    'id' => '1400',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Warangal Rural',

                ],
                [
                    'id' => '1401',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Warangal Urban',

                ],
                [
                    'id' => '1402',
                    'country_id' => '78',
                    'division_id' => '33',
                    'name' => 'Yadadri Bhuvanagiri',

                ],
                [
                    'id' => '1403',
                    'country_id' => '78',
                    'division_id' => '34',
                    'name' => 'Dhalai',

                ],
                [
                    'id' => '1404',
                    'country_id' => '78',
                    'division_id' => '34',
                    'name' => 'Gomati',

                ],
                [
                    'id' => '1405',
                    'country_id' => '78',
                    'division_id' => '34',
                    'name' => 'Khowai',

                ],
                [
                    'id' => '1406',
                    'country_id' => '78',
                    'division_id' => '34',
                    'name' => 'North Tripura',

                ],
                [
                    'id' => '1407',
                    'country_id' => '78',
                    'division_id' => '34',
                    'name' => 'Sepahijala',

                ],
                [
                    'id' => '1408',
                    'country_id' => '78',
                    'division_id' => '34',
                    'name' => 'South Tripura',

                ],
                [
                    'id' => '1409',
                    'country_id' => '78',
                    'division_id' => '34',
                    'name' => 'Unakoti',

                ],
                [
                    'id' => '1410',
                    'country_id' => '78',
                    'division_id' => '34',
                    'name' => 'West Tripura',

                ],
                [
                    'id' => '1411',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Agra',

                ],
                [
                    'id' => '1412',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Aligarh',

                ],
                [
                    'id' => '1413',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Prayagraj',

                ],
                [
                    'id' => '1414',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Ambedkar Nagar',

                ],
                [
                    'id' => '1415',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Amethi',

                ],
                [
                    'id' => '1416',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Amroha',

                ],
                [
                    'id' => '1417',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Auraiya',

                ],
                [
                    'id' => '1418',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Azamgarh',

                ],
                [
                    'id' => '1419',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Baghpat',

                ],
                [
                    'id' => '1420',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Bahraich',

                ],
                [
                    'id' => '1421',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Ballia',

                ],
                [
                    'id' => '1422',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Balrampur',

                ],
                [
                    'id' => '1423',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Banda',

                ],
                [
                    'id' => '1424',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Barabanki',

                ],
                [
                    'id' => '1425',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Bareilly',

                ],
                [
                    'id' => '1426',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Basti',

                ],
                [
                    'id' => '1427',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Bhadohi',

                ],
                [
                    'id' => '1428',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Bijnor',

                ],
                [
                    'id' => '1429',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Budaun',

                ],
                [
                    'id' => '1430',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Bulandshahr',

                ],
                [
                    'id' => '1431',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Chandauli',

                ],
                [
                    'id' => '1432',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Chitrakoot',

                ],
                [
                    'id' => '1433',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Deoria',

                ],
                [
                    'id' => '1434',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Etah',

                ],
                [
                    'id' => '1435',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Etawah',

                ],
                [
                    'id' => '1436',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Ayodhya',

                ],
                [
                    'id' => '1437',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Farrukhabad',

                ],
                [
                    'id' => '1438',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Fatehpur',

                ],
                [
                    'id' => '1439',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Firozabad',

                ],
                [
                    'id' => '1440',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Gautam Buddha Nagar',

                ],
                [
                    'id' => '1441',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Ghaziabad',

                ],
                [
                    'id' => '1442',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Ghazipur',

                ],
                [
                    'id' => '1443',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Gonda',

                ],
                [
                    'id' => '1444',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Gorakhpur',

                ],
                [
                    'id' => '1445',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Hamirpur',

                ],
                [
                    'id' => '1446',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Hapur',

                ],
                [
                    'id' => '1447',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Hardoi',

                ],
                [
                    'id' => '1448',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Hathras',

                ],
                [
                    'id' => '1449',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Jalaun',

                ],
                [
                    'id' => '1450',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Jaunpur',

                ],
                [
                    'id' => '1451',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Jhansi',

                ],
                [
                    'id' => '1452',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Kannauj',

                ],
                [
                    'id' => '1453',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Kanpur Dehat',

                ],
                [
                    'id' => '1454',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Kanpur Nagar',

                ],
                [
                    'id' => '1455',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Kasganj',

                ],
                [
                    'id' => '1456',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Kaushambi',

                ],
                [
                    'id' => '1457',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Kheri',

                ],
                [
                    'id' => '1458',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Kushinagar',

                ],
                [
                    'id' => '1459',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Lalitpur',

                ],
                [
                    'id' => '1460',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Lucknow',

                ],
                [
                    'id' => '1461',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Maharajganj',

                ],
                [
                    'id' => '1462',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Mahoba',

                ],
                [
                    'id' => '1463',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Mainpuri',

                ],
                [
                    'id' => '1464',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Mathura',

                ],
                [
                    'id' => '1465',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Mau',

                ],
                [
                    'id' => '1466',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Meerut',

                ],
                [
                    'id' => '1467',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Mirzapur',

                ],
                [
                    'id' => '1468',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Moradabad',

                ],
                [
                    'id' => '1469',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Muzaffarnagar',

                ],
                [
                    'id' => '1470',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Pilibhit',

                ],
                [
                    'id' => '1471',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Pratapgarh',

                ],
                [
                    'id' => '1472',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Raebareli',

                ],
                [
                    'id' => '1473',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Rampur',

                ],
                [
                    'id' => '1474',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Saharanpur',

                ],
                [
                    'id' => '1475',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Sambhal',

                ],
                [
                    'id' => '1476',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Sant Kabir Nagar',

                ],
                [
                    'id' => '1477',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Shahjahanpur',

                ],
                [
                    'id' => '1478',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Shamli',

                ],
                [
                    'id' => '1479',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Shravasti',

                ],
                [
                    'id' => '1480',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Siddharthnagar',

                ],
                [
                    'id' => '1481',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Sitapur',

                ],
                [
                    'id' => '1482',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Sonbhadra',

                ],
                [
                    'id' => '1483',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Sultanpur',

                ],
                [
                    'id' => '1484',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Unnao',

                ],
                [
                    'id' => '1485',
                    'country_id' => '78',
                    'division_id' => '35',
                    'name' => 'Varanasi',

                ],
                [
                    'id' => '1486',
                    'country_id' => '78',
                    'division_id' => '36',
                    'name' => 'Almora',

                ],
                [
                    'id' => '1487',
                    'country_id' => '78',
                    'division_id' => '36',
                    'name' => 'Bageshwar',

                ],
                [
                    'id' => '1488',
                    'country_id' => '78',
                    'division_id' => '36',
                    'name' => 'Chamoli',

                ],
                [
                    'id' => '1489',
                    'country_id' => '78',
                    'division_id' => '36',
                    'name' => 'Champawat',

                ],
                [
                    'id' => '1490',
                    'country_id' => '78',
                    'division_id' => '36',
                    'name' => 'Dehradun',

                ],
                [
                    'id' => '1491',
                    'country_id' => '78',
                    'division_id' => '36',
                    'name' => 'Haridwar',

                ],
                [
                    'id' => '1492',
                    'country_id' => '78',
                    'division_id' => '36',
                    'name' => 'Nainital',

                ],
                [
                    'id' => '1493',
                    'country_id' => '78',
                    'division_id' => '36',
                    'name' => 'Pauri',

                ],
                [
                    'id' => '1494',
                    'country_id' => '78',
                    'division_id' => '36',
                    'name' => 'Pithoragarh',

                ],
                [
                    'id' => '1495',
                    'country_id' => '78',
                    'division_id' => '36',
                    'name' => 'Rudraprayag',

                ],
                [
                    'id' => '1496',
                    'country_id' => '78',
                    'division_id' => '36',
                    'name' => 'Tehri',

                ],
                [
                    'id' => '1497',
                    'country_id' => '78',
                    'division_id' => '36',
                    'name' => 'Udham Singh Nagar',

                ],
                [
                    'id' => '1498',
                    'country_id' => '78',
                    'division_id' => '36',
                    'name' => 'Uttarkashi',

                ],
                [
                    'id' => '1499',
                    'country_id' => '78',
                    'division_id' => '37',
                    'name' => 'Alipurduar',

                ],
                [
                    'id' => '1500',
                    'country_id' => '78',
                    'division_id' => '37',
                    'name' => 'Bankura',

                ],
                [
                    'id' => '1501',
                    'country_id' => '78',
                    'division_id' => '37',
                    'name' => 'Birbhum',

                ],
                [
                    'id' => '1502',
                    'country_id' => '78',
                    'division_id' => '37',
                    'name' => 'Cooch Behar',

                ],
                [
                    'id' => '1503',
                    'country_id' => '78',
                    'division_id' => '37',
                    'name' => 'Dakshin Dinajpur',

                ],
                [
                    'id' => '1504',
                    'country_id' => '78',
                    'division_id' => '37',
                    'name' => 'Darjeeling',

                ],
                [
                    'id' => '1505',
                    'country_id' => '78',
                    'division_id' => '37',
                    'name' => 'Hooghly',

                ],
                [
                    'id' => '1506',
                    'country_id' => '78',
                    'division_id' => '37',
                    'name' => 'Howrah',

                ],
                [
                    'id' => '1507',
                    'country_id' => '78',
                    'division_id' => '37',
                    'name' => 'Jalpaiguri',

                ],
                [
                    'id' => '1508',
                    'country_id' => '78',
                    'division_id' => '37',
                    'name' => 'Jhargram',

                ],
                [
                    'id' => '1509',
                    'country_id' => '78',
                    'division_id' => '37',
                    'name' => 'Kalimpong',

                ],
                [
                    'id' => '1510',
                    'country_id' => '78',
                    'division_id' => '37',
                    'name' => 'Kolkata',

                ],
                [
                    'id' => '1511',
                    'country_id' => '78',
                    'division_id' => '37',
                    'name' => 'Malda',

                ],
                [
                    'id' => '1512',
                    'country_id' => '78',
                    'division_id' => '37',
                    'name' => 'Murshidabad',

                ],
                [
                    'id' => '1513',
                    'country_id' => '78',
                    'division_id' => '37',
                    'name' => 'Nadia',

                ],
                [
                    'id' => '1514',
                    'country_id' => '78',
                    'division_id' => '37',
                    'name' => 'North 24 Parganas',

                ],
                [
                    'id' => '1515',
                    'country_id' => '78',
                    'division_id' => '37',
                    'name' => 'Paschim Bardhaman',

                ],
                [
                    'id' => '1516',
                    'country_id' => '78',
                    'division_id' => '37',
                    'name' => 'Paschim Medinipur',

                ],
                [
                    'id' => '1517',
                    'country_id' => '78',
                    'division_id' => '37',
                    'name' => 'Purba Bardhaman',

                ],
                [
                    'id' => '1518',
                    'country_id' => '78',
                    'division_id' => '37',
                    'name' => 'Purba Medinipur',

                ],
                [
                    'id' => '1519',
                    'country_id' => '78',
                    'division_id' => '37',
                    'name' => 'Purulia',

                ],
                [
                    'id' => '1520',
                    'country_id' => '78',
                    'division_id' => '37',
                    'name' => 'South 24 Parganas',

                ],
                [
                    'id' => '1521',
                    'country_id' => '78',
                    'division_id' => '37',
                    'name' => 'Uttar Dinajpur',

                ],
                [
                    'id' => '1522',
                    'country_id' => '78',
                    'division_id' => '38',
                    'name' => 'Nicobar',

                ],
                [
                    'id' => '1523',
                    'country_id' => '78',
                    'division_id' => '38',
                    'name' => 'North Middle Andaman',

                ],
                [
                    'id' => '1524',
                    'country_id' => '78',
                    'division_id' => '38',
                    'name' => 'South Andaman',

                ],
                [
                    'id' => '1525',
                    'country_id' => '78',
                    'division_id' => '39',
                    'name' => 'Chandigarh',

                ],
                [
                    'id' => '1526',
                    'country_id' => '78',
                    'division_id' => '40',
                    'name' => 'Dadra Nagar Haveli',

                ],
                [
                    'id' => '1527',
                    'country_id' => '78',
                    'division_id' => '41',
                    'name' => 'Daman',

                ],
                [
                    'id' => '1528',
                    'country_id' => '78',
                    'division_id' => '42',
                    'name' => 'Diu',

                ],
                [
                    'id' => '1529',
                    'country_id' => '78',
                    'division_id' => '43',
                    'name' => 'Central Delhi',

                ],
                [
                    'id' => '1530',
                    'country_id' => '78',
                    'division_id' => '43',
                    'name' => 'East Delhi',

                ],
                [
                    'id' => '1531',
                    'country_id' => '78',
                    'division_id' => '43',
                    'name' => 'New Delhi',

                ],
                [
                    'id' => '1532',
                    'country_id' => '78',
                    'division_id' => '43',
                    'name' => 'North Delhi',

                ],
                [
                    'id' => '1533',
                    'country_id' => '78',
                    'division_id' => '43',
                    'name' => 'North East Delhi',

                ],
                [
                    'id' => '1534',
                    'country_id' => '78',
                    'division_id' => '43',
                    'name' => 'North West Delhi',

                ],
                [
                    'id' => '1535',
                    'country_id' => '78',
                    'division_id' => '43',
                    'name' => 'Shahdara',

                ],
                [
                    'id' => '1536',
                    'country_id' => '78',
                    'division_id' => '43',
                    'name' => 'South Delhi',

                ],
                [
                    'id' => '1537',
                    'country_id' => '78',
                    'division_id' => '43',
                    'name' => 'South East Delhi',

                ],
                [
                    'id' => '1538',
                    'country_id' => '78',
                    'division_id' => '43',
                    'name' => 'South West Delhi',

                ],
                [
                    'id' => '1539',
                    'country_id' => '78',
                    'division_id' => '43',
                    'name' => 'West Delhi',

                ],
                [
                    'id' => '1540',
                    'country_id' => '78',
                    'division_id' => '44',
                    'name' => 'Lakshadweep',

                ],
                [
                    'id' => '1541',
                    'country_id' => '78',
                    'division_id' => '45',
                    'name' => 'Kargil',

                ],
                [
                    'id' => '1542',
                    'country_id' => '78',
                    'division_id' => '45',
                    'name' => 'Leh',

                ],
                [
                    'id' => '1543',
                    'country_id' => '78',
                    'division_id' => '46',
                    'name' => 'Karaikal',
                ],
                [
                    'id' => '1544',
                    'country_id' => '78',
                    'division_id' => '46',
                    'name' => 'Mahe',
                ],
                [
                    'id' => '1545',
                    'country_id' => '78',
                    'division_id' => '46',
                    'name' => 'Puducherry',

                ],
                [
                    'id' => '1546',
                    'country_id' => '78',
                    'division_id' => '46',
                    'name' => 'Yanam',
                ],
            ];

        try {
            DB::beginTransaction();
            foreach ($districts as $key => $value) {
                $district = new District();
                $district->country_id = $value['country_id'];
                $district->division_id = $value['division_id'];
                $district->name = $value['name'];
                $district->bn_name = null;
                $district->status = 1;
                $district->save();
            }
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e->getMessage(), $e->getLine());
        }
    }
}
