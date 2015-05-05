<?php

class CompanyViewsTest extends BaseControllerTestCase {

    // Creation of campaigns

    public function testCreateResponse()
    {
        $crawler = $this->client->request('GET', '/company/create');

        $this->assertTrue($this->client->getResponse()->isOk());
    }

}