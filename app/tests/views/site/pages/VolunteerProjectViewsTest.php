<?php

class VolunteerProjectListViewsTest extends BaseControllerTestCase {

    // Creation of campaigns

    public function testCreateResponse()
    {
        // Login in as ngo1
        $credentials = array(
            'email'=>'ngo1@ngo1.com',
            'password'=>'ngo1',
            'csrf_token' => Session::getToken()
        );

        $this->withInput( $credentials )
            ->requestAction('POST', 'UserController@postLogin');

        $crawler = $this->client->request('GET', '/project/createVolunteerProject');

        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testCreateResponseNotAuthenticated()
    {
        $crawler = $this->client->request('GET', '/project/createVolunteerProject');

        $this->assertRedirection( URL::to('/') );
    }

    // List of all campaigns

    public function testListVolunteerProjectResponse()
    {
        $crawler = $this->client->request('GET', '/projects');

        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testVolunteerProject1Name()
    {
        $crawler = $this->client->request('GET', '/projectsFilter?category=2&city=Sevilla&startDate=2015-04-06&finishDate=2016-04-07');

        $this->assertCount(1, $crawler->filter('h3:contains("Project 1")'));
    }



    public function testVolunteerProjectNameLinkToDetails()
    {
        $crawler = $this->client->request('GET', '/projectsFilter?category=2&city=Sevilla&startDate=2015-04-06&finishDate=2016-04-07');

        $link = $crawler->selectLink('Project 1')->link();

        $url = $link->getUri();

        $this->assertEqualsUrlPath($url, 'project/view/1');
    }

    // List campaigns logged in as ngo1

    public function testListNGOVolunteerProjectResponse()
    {
        // Login in as ngo1
        $credentials = array(
            'email'=>'ngo1@ngo1.com',
            'password'=>'ngo1',
            'csrf_token' => Session::getToken()
        );

        $this->withInput( $credentials )
            ->requestAction('POST', 'UserController@postLogin');

        $crawler = $this->client->request('GET', '/project/myVolunteersProjects');

        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testListNGOVolunteerProjectResponseNotAuthenticated()
    {
        $crawler = $this->client->request('GET', '/project/myVolunteersProjects');

        $this->assertRedirection( URL::to('/') );
    }

    public function testNGOVolunteerProject1Name()
    {
        // Login in as ngo1
        $credentials = array(
            'email'=>'ngo1@ngo1.com',
            'password'=>'ngo1',
            'csrf_token' => Session::getToken()
        );

        $this->withInput( $credentials )
            ->requestAction('POST', 'UserController@postLogin');

        $crawler = $this->client->request('GET', '/project/myVolunteersProjects');

        $this->assertCount(1, $crawler->filter('h3:contains("Project 1")'));
    }

    public function testNGOVolunteerProject1NameLinkToDetails()
    {
        // Login in as ngo1
        $credentials = array(
            'email'=>'ngo1@ngo1.com',
            'password'=>'ngo1',
            'csrf_token' => Session::getToken()
        );

        $this->withInput( $credentials )
            ->requestAction('POST', 'UserController@postLogin');

        $crawler = $this->client->request('GET', '/project/myVolunteersProjects');

        $link = $crawler->selectLink('Project 1')->link();

        $url = $link->getUri();

        $this->assertEqualsUrlPath($url, 'project/view/1');
    }

    // Details of campaigns

    public function testDetailsVolunteerProject1Response()
    {
        $crawler = $this->client->request('GET', '/project/view/1');

        $this->assertTrue($this->client->getResponse()->isOk());
    }


    public function testDetailsCampaign1Description()
    {
        $crawler = $this->client->request('GET', '/campaign/details/1');

        $this->assertCount(1, $crawler->filter('p:contains("Example project 1")'));
    }
}