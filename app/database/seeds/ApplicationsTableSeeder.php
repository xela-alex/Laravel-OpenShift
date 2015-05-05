<?php

class ApplicationsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('application')->delete();

        $pros = Project::whereNull('company_id')->get();

        foreach($pros as $pro_fila){
            $pro_company = $pro_fila;
        }
        $pros = Project::whereNull('ngo_id')->get();

        foreach($pros as $pro_fila){
            $pro_ong = $pro_fila;
        }

        $applications = array(
            array(
                'moment'      => new DateTime,
                'comments'      => 'comments1',
                'result'   => 2,
                'project_id' => (int)$pro_company["id"],
                'volunteer_id' => Volunteer::where('name' , '=','volunteer1')->first()->id,


            ),

            array(
                'moment'      => new DateTime,
                'comments'      => 'comments2',
                'result'   => 2,
                'project_id' => (int)$pro_ong["id"],
                'volunteer_id' => Volunteer::where('name' , '=','volunteer2')->first()->id,

            ),

        );

        DB::table('application')->insert( $applications );
    }

}
