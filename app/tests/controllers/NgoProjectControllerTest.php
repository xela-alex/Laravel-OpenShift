<?php

class NgoProjectControllerTest extends BaseControllerTestCase {

    public function testListNGOVolunteerProjectResponse()
    {
        $this->flushSession();

        // Login in as ngo1
        $credentials = array(
            'email'=>'ngo1@ngo1.com',
            'password'=>'ngo1',
            'csrf_token' => Session::getToken()
        );

        $this->withInput( $credentials )
            ->requestAction('POST', 'UserController@postLogin');

        $this->requestAction('GET', 'NgoProjectController@findMyVolunteersProjects');
        $this->assertResponseOk();
    }

    public function testListNGOVolunteerProjectNotAuthenticated()
    {
        $this->flushSession();

        $this->requestAction('GET', 'NgoProjectController@findMyVolunteersProjects');
        $this->assertRedirectedTo('/');
    }

    public function testListNGOVolunteerProjectAuthenticatedAsACompany()
    {
        $this->flushSession();

        // Login in as company1
        $credentials = array(
            'email'=>'company@company1.com',
            'password'=>'company1',
            'csrf_token' => Session::getToken()
        );

        $this->withInput( $credentials )
            ->requestAction('POST', 'UserController@postLogin');

        $this->requestAction('GET', 'NgoProjectController@findMyVolunteersProjects');
        $this->assertRedirectedTo('/');
    }

    public function testListNGOVolunteerProjectVariables()
    {
        $this->flushSession();

        // Login in as ngo1
        $credentials = array(
            'email'=>'ngo1@ngo1.com',
            'password'=>'ngo1',
            'csrf_token' => Session::getToken()
        );

        $this->withInput( $credentials )
            ->requestAction('POST', 'UserController@postLogin');

        $this->requestAction('GET', 'NgoProjectController@findMyVolunteersProjects');
        $this->assertViewHas('viewNgoMyProjects');
        $this->assertViewHas('projects');
        $this->assertViewHas('emptyProjects');

    }



    // Creation of a new Volunteer project

    public function testCreateVolunteerProjectResponse()
    {
        $this->flushSession();

        // Login in as ngo1
        $credentials = array(
            'email' => 'ngo1@ngo1.com',
            'password' => 'ngo1',
            'csrf_token' => Session::getToken()
        );

        $this->withInput($credentials)
            ->requestAction('POST', 'UserController@postLogin');

        $this->requestAction('GET', 'NgoProjectController@createVolunteerProject');
        $this->assertResponseOk();
    }



    public function testCreateVolunteerProjectRequiredField()
    {
        $this->flushSession();

        // Login in as ngo1
        $credentials = array(
            'email'=>'ngo1@ngo1.com',
            'password'=>'ngo1',
            'csrf_token' => Session::getToken()
        );

        $this->withInput( $credentials )
            ->requestAction('POST', 'UserController@postLogin');

        $this->requestAction('GET', 'NgoProjectController@createVolunteerProject');

        // Create new campaign
        $campaignData = array(
//            'name'                          => 'ngo  3',
            'address'                       => 'calle liberty',
            'city'                          => 'Sevilla',
            'zipCode'                       => '41930',
            'country'                       => 'España',
            'maxVolunteers '                => 20,
            'description'                   => 'Description volunteer project 3',
            'startDate'                     =>  \Carbon\Carbon::createFromDate(2015,7,23)->toDateTimeString(),
            'finishDate'                    =>  \Carbon\Carbon::createFromDate(2015,8,23)->toDateTimeString(),
            'category'                      =>  2
        );

        $this->withInput( $campaignData )->requestAction('POST', 'NgoProjectController@saveVolunteerProject');
        $this->assertRedirectedTo( URL::to('project/createVolunteerProject'));
        $this->assertSessionHasErrors('name');
    }

    public function testCreateVolunteerProjectNotEnoughLength()
    {
        $this->flushSession();

        // Login in as ngo1
        $credentials = array(
            'email'=>'ngo1@ngo1.com',
            'password'=>'ngo1',
            'csrf_token' => Session::getToken()
        );

        $this->withInput( $credentials )
            ->requestAction('POST', 'UserController@postLogin');

        $this->requestAction('GET', 'NgoProjectController@createVolunteerProject');

        // Create new campaign
        $campaignData = array(
            'name'                          => 'ng',
            'address'                       => 'calle liberty',
            'city'                          => 'Sevilla',
            'zipCode'                       => '41930',
            'country'                       => 'España',
            'maxVolunteers '                => 20,
            'description'                   => 'Description volunteer project 3',
            'startDate'                     =>  \Carbon\Carbon::createFromDate(2015,7,23)->toDateTimeString(),
            'finishDate'                    =>  \Carbon\Carbon::createFromDate(2015,8,23)->toDateTimeString(),
            'category'                      =>  2
        );

        $this->withInput( $campaignData )->requestAction('POST', 'NgoProjectController@saveVolunteerProject');
        $this->assertRedirectedTo( URL::to('project/createVolunteerProject'));
        $this->assertSessionHasErrors('name');

    }

    public function testCreateVolunteerProjectImageFieldIsNotAnImage()
    {
        $this->flushSession();

        // Login in as ngo1
        $credentials = array(
            'email'=>'ngo1@ngo1.com',
            'password'=>'ngo1',
            'csrf_token' => Session::getToken()
        );

        $this->withInput( $credentials )
            ->requestAction('POST', 'UserController@postLogin');

        $this->requestAction('GET', 'NgoProjectController@createVolunteerProject');

        // Create new campaign
        $campaignData = array(
//            'name'                          => 'ngo  3',
            'address'                       => 'calle liberty',
            'city'                          => 'Sevilla',
            'zipCode'                       => '41930',
            'country'                       => 'España',
            'maxVolunteers '                => 20,
            'description'                   => 'Description volunteer project 3',
            'startDate'                     =>  \Carbon\Carbon::createFromDate(2015,7,23)->toDateTimeString(),
            'finishDate'                    =>  \Carbon\Carbon::createFromDate(2015,8,23)->toDateTimeString(),
            'category'                      =>  2,
            'logo'                          => 'logo'
        );

        $this->withInput( $campaignData )->requestAction('POST', 'NgoProjectController@saveVolunteerProject');
        $this->assertRedirectedTo( URL::to('project/createVolunteerProject'));
        $this->assertSessionHasErrors('logo');
    }
}
