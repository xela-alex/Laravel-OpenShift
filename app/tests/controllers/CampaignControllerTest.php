<?php

class CampaignControllerTest extends BaseControllerTestCase {

    // List of all campaigns

    public function testListAllCampaignsResponse()
    {
        $this->flushSession();

        $this->requestAction('GET', 'CampaignController@findAllCampaigns');
        $this->assertResponseOk();
    }

    public function testListAllCampaignsVariables()
    {
        $this->flushSession();

        $this->requestAction('GET', 'CampaignController@findAllCampaigns');
        $this->assertViewHas('campaigns');
    }

    // List of NGO campaigns

    public function testListNGOCampaignsResponse()
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

        $this->requestAction('GET', 'CampaignController@findCampaignsByCurrentNGO');
        $this->assertResponseOk();
    }

    public function testListNGOCampaignsNotAuthenticated()
    {
        $this->flushSession();

        $this->requestAction('GET', 'CampaignController@findCampaignsByCurrentNGO');
        $this->assertRedirectedTo('/');
    }

    public function testListNGOCampaignsAuthenticatedAsACompany()
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

        $this->requestAction('GET', 'CampaignController@findCampaignsByCurrentNGO');
        $this->assertRedirectedTo('/');
    }

    public function testListNGOCampaignsVariables()
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

        $this->requestAction('GET', 'CampaignController@findCampaignsByCurrentNGO');
        $this->assertViewHas('campaigns');
    }

    // Details of a campaign

    /*public function testDetailsOfCampaignResponse()
    {
        $this->flushSession();

        $this->call('GET', 'CampaignController@campaignDetails', array('id' => 1));
        $this->assertResponseOk();
    }

    public function testDetailsOfCampaignVariables()
    {
        $this->flushSession();

        $this->call('GET', 'CampaignController@campaignDetails', array('id' => 1));
        $this->assertResponseOk();

        $this->assertSessionHas('campaign');
        $this->assertSessionHas('ngo');
        $this->assertNotNull(Session::get('campaign'));
        $this->assertNotNull(Session::get('ngo'));
        $this->assertViewHas('campaigns');
        $this->assertViewHas('ngo');
    }*/

    // Creation of a new campaign

    public function testCreateCampaignResponse()
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

        $this->requestAction('GET', 'CampaignController@createCampaign');
        $this->assertResponseOk();
    }

    /* This test can't be performed due to a JavaScript DatePicker is being used, so it's necessary to use a testing tool focused on user interactions like Selenium */
    /*public function testCreateCampaignSuccessful()
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

        $this->requestAction('GET', 'CampaignController@createCampaign');

        // Create new campaign
        $campaignData = array(
            'name'                          => 'Campaign 3',
            'description'                   => 'Description campaign 3',
            'image'                         =>  new Symfony\Component\HttpFoundation\File\UploadedFile('C:\ds-firebird-logo-500.png', 'ds-firebird-logo-500.png'),
            'startDate'                     =>  \Carbon\Carbon::createFromDate(2015,7,23)->toDateTimeString(),
            'finishDate'                    =>  \Carbon\Carbon::createFromDate(2015,8,23)->toDateTimeString(),
            'link'                          => 'http://www.blahblahblah3.com',
            'maxVisits'                     => 4000,
            'promotionDuration'             => 60,
        );

        $this->withInput( $campaignData )->requestAction('POST', 'CampaignController@saveCampaign');
        $this->assertRedirectedTo( URL::to('myCampaigns'));
        $this->assertViewHas('success');
    }*/

    public function testCreateCampaignRequiredField()
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

        $this->requestAction('GET', 'CampaignController@createCampaign');

        // Create new campaign
        $campaignData = array(
            //'name'                          => 'Campaign 3',
            'description'                   => 'Description campaign 3',
            'image'                         =>  new Symfony\Component\HttpFoundation\File\UploadedFile('C:\ds-firebird-logo-500.png', 'ds-firebird-logo-500.png'),
            'startDate'                     =>  \Carbon\Carbon::createFromDate(2015,7,23)->toDateTimeString(),
            'finishDate'                    =>  \Carbon\Carbon::createFromDate(2015,8,23)->toDateTimeString(),
            'link'                          => 'http://www.blahblahblah3.com',
            'maxVisits'                     => '4000',
            'promotionDuration'             => 60,
        );

        $this->withInput( $campaignData )->requestAction('POST', 'CampaignController@saveCampaign');
        $this->assertRedirectedTo( URL::to('campaign/create'));
        $this->assertSessionHasErrors('name');
    }

    public function testCreateCampaignNotEnoughLength()
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

        $this->requestAction('GET', 'CampaignController@createCampaign');

        // Create new campaign
        $campaignData = array(
            'name'                          => 'Ca',
            'description'                   => 'Description campaign 3',
            'image'                         =>  new Symfony\Component\HttpFoundation\File\UploadedFile('C:\ds-firebird-logo-500.png', 'ds-firebird-logo-500.png'),
            'startDate'                     =>  \Carbon\Carbon::createFromDate(2015,7,23)->toDateTimeString(),
            'finishDate'                    =>  \Carbon\Carbon::createFromDate(2015,8,23)->toDateTimeString(),
            'link'                          => 'http://www.blahblahblah3.com',
            'maxVisits'                     => 4000,
            'promotionDuration'             => 60,
        );

        $this->withInput( $campaignData )->requestAction('POST', 'CampaignController@saveCampaign');
        $this->assertRedirectedTo( URL::to('campaign/create'));
        $this->assertSessionHasErrors('name');
    }

    public function testCreateCampaignImageFieldIsNotAnImage()
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

        $this->requestAction('GET', 'CampaignController@createCampaign');

        // Create new campaign
        $campaignData = array(
            'name'                          => 'Campaign 3',
            'description'                   => 'Description campaign 3',
            'image'                         =>  'abc',
            'startDate'                     =>  \Carbon\Carbon::createFromDate(2015,7,23)->toDateTimeString(),
            'finishDate'                    =>  \Carbon\Carbon::createFromDate(2015,8,23)->toDateTimeString(),
            'link'                          => 'http://www.blahblahblah3.com',
            'maxVisits'                     => 4000,
            'promotionDuration'             => 60,
        );

        $this->withInput( $campaignData )->requestAction('POST', 'CampaignController@saveCampaign');
        $this->assertRedirectedTo( URL::to('campaign/create'));
        $this->assertSessionHasErrors('image');
    }

    public function testCreateCampaignLinkFieldDoesNotMatchPattern()
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

        $this->requestAction('GET', 'CampaignController@createCampaign');

        // Create new campaign
        $campaignData = array(
            'name'                          => 'Campaign 3',
            'description'                   => 'Description campaign 3',
            'image'                         =>  new Symfony\Component\HttpFoundation\File\UploadedFile('C:\ds-firebird-logo-500.png', 'ds-firebird-logo-500.png'),
            'startDate'                     =>  \Carbon\Carbon::createFromDate(2015,7,23)->toDateTimeString(),
            'finishDate'                    =>  \Carbon\Carbon::createFromDate(2015,8,23)->toDateTimeString(),
            'link'                          => 'abc',
            'maxVisits'                     => 4000,
            'promotionDuration'             => 60,
        );

        $this->withInput( $campaignData )->requestAction('POST', 'CampaignController@saveCampaign');
        $this->assertRedirectedTo( URL::to('campaign/create'));
        $this->assertSessionHasErrors('link');
    }

}
