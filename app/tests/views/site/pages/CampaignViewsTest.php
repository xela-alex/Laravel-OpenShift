<?php

class CampaignViewsTest extends BaseControllerTestCase {

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

        $crawler = $this->client->request('GET', '/campaign/create');

        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testCreateResponseNotAuthenticated()
    {
        $crawler = $this->client->request('GET', '/campaign/create');

        $this->assertRedirection( URL::to('/') );
    }

    // List of all campaigns

    public function testListCampaignsResponse()
    {
        $crawler = $this->client->request('GET', '/campaigns');

        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testCampaign1Name()
    {
        $crawler = $this->client->request('GET', '/campaigns');

        $this->assertCount(1, $crawler->filter('p:contains("Campaign 1")'));
    }

    public function testCampaign2Name()
    {
        $crawler = $this->client->request('GET', '/campaigns');

        $this->assertCount(1, $crawler->filter('p:contains("Campaign 2")'));
    }

    public function testCampaign1NameLinkToDetails()
    {
        $crawler = $this->client->request('GET', '/campaigns');

        $link = $crawler->selectLink('Campaign 1')->link();

        $url = $link->getUri();

        $this->assertEqualsUrlPath($url, 'campaign/details/1');
    }

    public function testCampaign2NameLinkToDetails()
    {
        $crawler = $this->client->request('GET', '/campaigns');

        $link = $crawler->selectLink('Campaign 2')->link();

        $url = $link->getUri();

        $this->assertEqualsUrlPath($url, 'campaign/details/2');
    }

    // List campaigns logged in as ngo1

    public function testListNGOCampaignsResponse()
    {
        // Login in as ngo1
        $credentials = array(
            'email'=>'ngo1@ngo1.com',
            'password'=>'ngo1',
            'csrf_token' => Session::getToken()
        );

        $this->withInput( $credentials )
            ->requestAction('POST', 'UserController@postLogin');

        $crawler = $this->client->request('GET', '/myCampaigns');

        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testListNGOCampaignsResponseNotAuthenticated()
    {
        $crawler = $this->client->request('GET', '/myCampaigns');

        $this->assertRedirection( URL::to('/') );
    }

    public function testNGOCampaign1Name()
    {
        // Login in as ngo1
        $credentials = array(
            'email'=>'ngo1@ngo1.com',
            'password'=>'ngo1',
            'csrf_token' => Session::getToken()
        );

        $this->withInput( $credentials )
            ->requestAction('POST', 'UserController@postLogin');

        $crawler = $this->client->request('GET', '/myCampaigns');

        $this->assertCount(1, $crawler->filter('p:contains("Campaign 1")'));
    }

    public function testNGOCampaign1NameLinkToDetails()
    {
        // Login in as ngo1
        $credentials = array(
            'email'=>'ngo1@ngo1.com',
            'password'=>'ngo1',
            'csrf_token' => Session::getToken()
        );

        $this->withInput( $credentials )
            ->requestAction('POST', 'UserController@postLogin');

        $crawler = $this->client->request('GET', '/myCampaigns');

        $link = $crawler->selectLink('Campaign 1')->link();

        $url = $link->getUri();

        $this->assertEqualsUrlPath($url, 'campaign/details/1');
    }

    // Details of campaigns

    public function testDetailsCampaign1Response()
    {
        $crawler = $this->client->request('GET', '/campaign/details/1');

        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testDetailsCampaign2Response()
    {
        $crawler = $this->client->request('GET', '/campaign/details/2');

        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testDetailsCampaign1Description()
    {
        $crawler = $this->client->request('GET', '/campaign/details/1');

        $this->assertCount(1, $crawler->filter('p:contains("Description campaign 1")'));
    }

    public function testDetailsCampaign2Description()
    {
        $crawler = $this->client->request('GET', '/campaign/details/2');

        $this->assertCount(1, $crawler->filter('p:contains("Description campaign 2")'));
    }

}