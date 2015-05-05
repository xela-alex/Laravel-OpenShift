<?php

use Illuminate\Database\Query\Builder;

class UserTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        $this->user = User::where('username', '=', 'administrator1')->first();
        $this->getUserByUsernameOK = $this->user->getUserByUsername('administrator1');
        $this->getUserByUsernameFail = $this->user->getUserByUsername('administrator3');
        $this->admin1Roles = $this->user->currentRoleIds();
        $this->adminRole = Role::where('id', '=', $this->admin1Roles[0])->first()->name;
    }

    public function testUsername()
    {
        $this->assertEquals($this->user->username, 'administrator1');
    }

    public function testIsConfirmedByEmail()
    {
        $this->assertEquals($this->user->isConfirmed(array('email' => 'admin1@piecebypeace.com')), 1);
    }

    public function testGetByUsername()
    {
        $this->assertNotEquals($this->getUserByUsernameOK, false);
    }

    public function testGetByUsernameFail()
    {
        $this->assertEquals($this->user->getUserByUsernameFail, false);
    }

    public function testUserHasAnyRole()
    {
        $this->assertEquals($this->adminRole, 'ADMINISTRATOR');
    }

    public function testUserHasOnlyOneRole()
    {
        $this->assertEquals( count($this->admin1Roles), 1 );
    }

}
