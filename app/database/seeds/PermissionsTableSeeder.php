<?php

class PermissionsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('permissions')->delete();

        $permissions = array(
            array( // 1
                'name'         => 'manage_all_administrator',
                'display_name' => 'manage all administrator'
            ),
            array( // 2
                'name'         => 'manage_all_volunteer',
                'display_name' => 'manage all volunteer'
            ),
            array( // 3
                'name'         => 'manage_all_company',
                'display_name' => 'manage all company'
            ),
            array( // 4
                'name'         => 'manage_all_ngo',
                'display_name' => 'manage all ngo'
            ),
        );

        DB::table('permissions')->insert( $permissions );

        DB::table('permission_role')->delete();

        $role_id_admin = Role::where('name', '=', 'ADMINISTRATOR')->first()->id;
        $role_id_volunteer = Role::where('name', '=', 'VOLUNTEER')->first()->id;
        $role_id_company = Role::where('name', '=', 'COMPANY')->first()->id;
        $role_id_ngo = Role::where('name', '=', 'NonGovernmentalOrganization')->first()->id;
        $permission_base = (int)DB::table('permissions')->first()->id - 1;

        $permissions = array(
            array(
                'role_id'       => $role_id_admin,
                'permission_id' => $permission_base + 1
            ),
            array(
                'role_id'       => $role_id_volunteer,
                'permission_id' => $permission_base + 2
            ),
            array(
                'role_id'       => $role_id_company,
                'permission_id' => $permission_base + 3
            ),
            array(
                'role_id'       => $role_id_ngo,
                'permission_id' => $permission_base + 4
            ),
        );

        DB::table('permission_role')->insert( $permissions );
    }

}