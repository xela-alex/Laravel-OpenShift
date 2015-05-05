<?php

class NGOsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('ngo')->delete();


        $ngos = array(
            array(
                'name'=>'NGO-1',
                'banned'=>0,
                'holderName'      => 'NGO 1',
                'brandName'      => 'Visa',
                'number'   => '4532820703718551',
                'expirationMonth'   => 10,
                'expirationYear' => 2015,
                'cvv' => 507,
                'description' => 'NGO1 NGO1 NGO1 NGO1',
                'phone' => '612345678',
                'active' => true,
                'logo'=> '/logos/imageNotFound.gif',
                'user_id' => User::where('username','=','ngo1')->first()->id,
            ),
            array(
                'name'=>'NGO-2',
                'banned'=>0,
                'holderName'      => 'NGO 2',
                'brandName'      => 'Visa',
                'number'   => '4916606973228728',
                'expirationMonth'   => 11,
                'expirationYear' => 2016,
                'cvv' => 508,
                'description' => 'NGO2 NGO2 NGO2 NGO2',
                'phone' => '687654321',
                'active' => true,
                'logo'=> '/logos/imageNotFound.gif',
                'user_id' => User::where('username','=','ngo2')->first()->id,
            ),
        );

        DB::table('ngo')->insert( $ngos );
    }

}
