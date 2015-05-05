<?php

class VolunteersTableSeeder extends Seeder {

    public function run()
    {
        DB::table('volunteer')->delete();
        DB::table('project_volunteer')->delete();


        $volunteers = array(
            array(
                'name'      => 'volunteer1',
                'banned'   => 0,
                'surname'   => 'surname1',
                'address'   => 'address1',
                'city'   => 'Sevilla',
                'zipCode'   => '49999',
                'country'   => 'España',
                'biography' => 'biography1',
                'user_id' => User::where('username','=','volunteer1')->first()->id,

            ),
            array(
                'name'      => 'volunteer2',
                'banned'   => 0,
                'surname'   => 'surname2',
                'address'   => 'address2',
                'city'   => 'Madrid',
                'zipCode'   => '47856',
                'country'   => 'España',
                'biography' => 'biography2',
                'user_id' => User::where('username','=','volunteer2')->first()->id,
            ),

        );

        DB::table('volunteer')->insert( $volunteers );
        $pros = Project::whereNull('company_id')->get();

        foreach($pros as $pro_fila){
            $pro_company = $pro_fila;
        }
        $pros = Project::whereNull('ngo_id')->get();

        foreach($pros as $pro_fila){
            $pro_ong = $pro_fila;
        }

        $project_volunteer = array(
            array(
                'project_id'      => (int)$pro_company["id"],
                'volunteer_id'    => Volunteer::where('name','=','volunteer1')->first()->id,


            ),
            array(
                'project_id'      => (int)$pro_ong["id"],
                'volunteer_id'    => Volunteer::where('name','=','volunteer2')->first()->id,

            ),

        );


        DB::table('project_volunteer')->insert( $project_volunteer );

    }

}
