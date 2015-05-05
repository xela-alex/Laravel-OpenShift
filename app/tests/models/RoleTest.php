<?php

class RoleTest extends TestCase {

    public function setUp(){
        parent::setUp();
        $this->roleAdmin = Role::where('name', '=', 'ADMINISTRATOR')->first();
        $this->roleNgo = Role::where('name', '=', 'NonGovernmentalOrganization')->first();
        $this->roleVolunteer = Role::where('name', '=', 'VOLUNTEER')->first();
        $this->roleCompany = Role::where('name', '=', 'COMPANY')->first();
        $this->roleNgoNoValid = Role::where('name', '=', 'NGO')->first();
    }

    public function testAllRoles()
    {
        $this->assertNotEmpty( $this->roleAdmin->name );
        $this->assertNotEmpty( $this->roleAdmin->name );
        $this->assertNotEmpty( $this->roleAdmin->name );
        $this->assertNotEmpty( $this->roleAdmin->name );
    }

    public function testNGOIsNotARole()
    {
        $this->assertEmpty( $this->roleNgoNoValid );
    }
}