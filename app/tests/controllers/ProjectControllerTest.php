<?php

class ProjectControllerTest extends BaseControllerTestCase {

    // List of all VolunteerProjects

    public function testListAllVolunteerProjectsResponse()
    {
        $this->flushSession();

        $this->requestAction('GET', 'ProjectController@findVolunteerProjects');
        $this->assertResponseOk();
    }

    public function testListAllVolunteerVariables()
    {
        $this->flushSession();

        $this->requestAction('GET', 'ProjectController@findVolunteerProjects');
        $this->assertViewHas('categories');
        $this->assertViewHas('locations');
        $this->assertViewHas('projects');
        $this->assertViewHas('emptyProjects');
    }

      public function testFilterVolunteerProjects()
    {

        $this->requestAction('GET', 'ProjectController@findVolunteerProjects');

        // Create new campaign
        $data = array(
            'category'                      => '2',//addictions id
            'city'                          => 'Sevilla',
            'startDate'                     =>  \Carbon\Carbon::createFromDate(2015,4,8)->toDateTimeString(),
            'finishDate'                    =>  \Carbon\Carbon::createFromDate(2016,8,23)->toDateTimeString(),

        );
        $this->withInput( $data )->requestAction('Get', 'NgoController@findVolunteerProjects');
        $this->assertResponseOk();
        $this->assertViewHas('categories');
        $this->assertViewHas('locations');
        $this->assertViewHas('projects');
        $this->assertViewHas('emptyProjects');
    }

}
