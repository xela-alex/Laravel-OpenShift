<?php

class CompaniesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('company')->delete();


        $companies = array(
            array(
                'name'      => 'company1',
                'banned'   => 0,
                'sector'   => 'sector1',
                'description' => 'descripcion',
                'phone' => '646464646',
                'active' =>1,
                'logo'=> '/logos/imageNotFound.gif',
                'user_id' => User::where('username','=','company1')->first()->id,



            ),
            array(
                'name'      => 'company2',
                'banned'   => 0,
                'sector'   => 'sector2',
                'description' => 'descripcion2',
                'phone' => '622211365',
                'active' =>1,
                'logo'=> '/logos/imageNotFound.gif',
                'user_id' => User::where('username','=','company2')->first()->id,


            ),

        );

        DB::table('company')->insert( $companies );
    }

}
