<?php

class RolesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('roles')->delete();

        $administratorRole = new Role;
        $administratorRole->name = 'ADMINISTRATOR';
        $administratorRole->save();

        $ngoRole = new Role;
        $ngoRole->name = 'NonGovernmentalOrganization';
        $ngoRole->save();

        $volunteerRole = new Role;
        $volunteerRole ->name = 'VOLUNTEER';
        $volunteerRole ->save();

        $companyRole = new Role;
        $companyRole ->name = 'COMPANY';
        $companyRole ->save();

        $user = User::where('username','=','administrator1')->first();
        $user->attachRole( $administratorRole );

        $user = User::where('username','=','administrator2')->first();
        $user->attachRole( $administratorRole );

        $user = User::where('username','=','ngo1')->first();
        $user->attachRole( $ngoRole );

        $user = User::where('username','=','ngo2')->first();
        $user->attachRole( $ngoRole );

        $user = User::where('username','=','volunteer1')->first();
        $user->attachRole( $volunteerRole );

        $user = User::where('username','=','volunteer2')->first();
        $user->attachRole( $volunteerRole );

        $user = User::where('username','=','company1')->first();
        $user->attachRole( $companyRole );

        $user = User::where('username','=','company2')->first();
        $user->attachRole( $companyRole );

    }

}
