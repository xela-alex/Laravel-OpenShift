<?php

use Illuminate\Database\Query\Builder;

class CampaignTest extends TestCase {

    public function setUp(){
        parent::setUp();
        $this->campaign = Campaign::find(1);
        $this->ngo = Ngo::find($this->campaign->ngo_id);
    }

    public function testName()
    {
        $campaign = $this->campaign;
        $this->assertEquals( $campaign->name, 'Campaign 1' );
    }

    public function testNameIsAString()
    {
        $campaign = $this->campaign;
        $this->assertInternalType( 'string', $campaign->name);
    }

    public function testDescription()
    {
        $campaign = $this->campaign;
        $this->assertEquals( $campaign->description, 'Description campaign 1' );
    }

    public function testDescriptionIsAString()
    {
        $campaign = $this->campaign;
        $this->assertInternalType( 'string', $campaign->description);
    }

    public function testImage()
    {
        $campaign = $this->campaign;
        $this->assertNull( $campaign->image );
    }

    public function testStartDate()
    {
        $campaign = $this->campaign;
        $this->assertEquals( date('Y-m-d', strtotime($campaign->startDate)), date('Y-m-d', strtotime(\Carbon\Carbon::createFromDate(2015,7,23))));
    }

    public function testStartDateIsADate()
    {
        $campaign = $this->campaign;
        $this->assertInternalType( 'string', date('Y-m-d', strtotime($campaign->startDate)));
    }

    public function testFinishDate()
    {
        $campaign = $this->campaign;
        $this->assertEquals( date('Y-m-d', strtotime($campaign->finishDate)), date('Y-m-d', strtotime(\Carbon\Carbon::createFromDate(2015,8,23))));
    }

    public function testFinishDateIsADate()
    {
        $campaign = $this->campaign;
        $this->assertInternalType( 'string', date('Y-m-d', strtotime($campaign->finishDate)));
    }

    public function testStartDateAfterCurrentDate()
    {
        $campaign = $this->campaign;
        $this->assertGreaterThan( $campaign->startDate, new DateTime('now'));
    }

    public function testFinishDateAfterCurrentDate()
    {
        $campaign = $this->campaign;
        $this->assertGreaterThan( $campaign->finishDate, new DateTime('now'));
    }

    public function testStartDateAfterFinishDate()
    {
        $campaign = $this->campaign;
        $this->assertGreaterThan( $campaign->startDate, $campaign->finishDate());
    }

    public function testVisits()
    {
        $campaign = $this->campaign;
        $this->assertEquals( $campaign->visits, 0);
    }

    public function testVisitsIsAnInt()
    {
        $campaign = $this->campaign;
        $this->assertInternalType( 'int', (int) $campaign->visits);
    }

    public function testVisitsAreAlwaysPositive()
    {
        $campaign = $this->campaign;
        $this->assertGreaterThanOrEqual( $campaign->visits, 0);
    }

    public function testLink()
    {
        $campaign = $this->campaign;
        $this->assertEquals( $campaign->link, 'http://www.blahblahblah.com');
    }

    public function testLinkIsAString()
    {
        $campaign = $this->campaign;
        $this->assertInternalType( 'string', $campaign->link);
    }

    public function testLinkComplainsWithURLPattern()
    {
        $campaign = $this->campaign;
        $this->assertRegExp('{http://.*}', $campaign->link);
    }

    public function testMaxVisits()
    {
        $campaign = $this->campaign;
        $this->assertEquals( (int) $campaign->maxVisits, 100);
    }

    public function testMaxVisitsIsAnInt()
    {
        $campaign = $this->campaign;
        $this->assertInternalType( 'int', (int) $campaign->maxVisits);
    }

    public function testMaxVisitsAreAlwaysPositive()
    {
        $campaign = $this->campaign;
        $this->assertGreaterThanOrEqual( 0,  (int) $campaign->maxVisits);
    }

    public function testHasNGOAssociated()
    {
        $campaign = $this->campaign;
        $ngo = Ngo::where('id','=',$campaign->ngo);
        $this->assertNotNull( $ngo );
    }

    public function testCorrectNgo()
    {
        $campaign = $this->campaign;
        $this->assertEquals( $this->ngo->name, 'NGO-1' );
    }

}
