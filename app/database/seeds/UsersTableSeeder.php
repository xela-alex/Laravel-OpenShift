<?php

class UsersTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();


        $users = array(
            array(
                'username'      => 'administrator1',
                'email'      => 'admin1@piecebypeace.com',
                'password'   => Hash::make('administrator1'),
                'confirmed'   => 1,
                'confirmation_code' => md5(microtime().Config::get('app.key')),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'username'      => 'administrator2',
                'email'      => 'admin2@piecebypeace.com',
                'password'   => Hash::make('administrator2'),
                'confirmed'   => 1,
                'confirmation_code' => md5(microtime().Config::get('app.key')),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'username'      => 'volunteer1',
                'email'      => 'volunteer1@gmail.com',
                'password'   => Hash::make('volunteer1'),
                'confirmed'   => 1,
                'confirmation_code' => md5(microtime().Config::get('app.key')),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'username'      => 'volunteer2',
                'email'      => 'volunteer2@gmail.com',
                'password'   => Hash::make('volunteer2'),
                'confirmed'   => 1,
                'confirmation_code' => md5(microtime().Config::get('app.key')),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'username'      => 'company1',
                'email'      => 'company1@company1.com',
                'password'   => Hash::make('company1'),
                'confirmed'   => 1,
                'confirmation_code' => md5(microtime().Config::get('app.key')),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'username'      => 'company2',
                'email'      => 'company2@company2.com',
                'password'   => Hash::make('company2'),
                'confirmed'   => 1,
                'confirmation_code' => md5(microtime().Config::get('app.key')),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'username'      => 'ngo1',
                'email'      => 'ngo1@ngo1.com',
                'password'   => Hash::make('ngo1'),
                'confirmed'   => 1,
                'confirmation_code' => md5(microtime().Config::get('app.key')),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'username'      => 'ngo2',
                'email'      => 'ngo2@ngo2.com',
                'password'   => Hash::make('ngo2'),
                'confirmed'   => 1,
                'confirmation_code' => md5(microtime().Config::get('app.key')),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
        );

        DB::table('users')->insert( $users );
    }

}
