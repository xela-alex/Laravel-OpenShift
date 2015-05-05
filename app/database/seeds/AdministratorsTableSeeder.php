<?php

class AdministratorsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('administrator')->delete();


        $administrators = array(
            array(
                'name'      => 'Administrator 1',
                'banned'      => false,
                'user_id' => User::where('username','=','administrator1')->first()->id,
            ),
            array(
                'name'      => 'Administrator 2',
                'banned'      => false,
                'user_id' => User::where('username','=','administrator2')->first()->id,
            ),
        );

        DB::table('administrator')->insert( $administrators );
    }

}
