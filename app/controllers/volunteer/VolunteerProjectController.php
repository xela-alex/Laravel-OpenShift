<?php

class VolunteerProjectController extends BaseController
{

    protected $volunteer;

    public function __construct()
    {
        parent::__construct();

    }

    public function findMyVolunteersProjects()
    {

        $this->volunteer = Volunteer::where('user_id', '=', Auth::id())->first();

        $projects = Project::whereNull('company_id')->whereHas('volunteers', function ($q) {
            $q->where('volunteer_id', 'like', $this->volunteer->id);
        })->paginate(4);

        $emptyProjects = false;
        if ($projects->getTotal() == 0) {
            $emptyProjects = true;
        }

        $data = array(
            'projects' => $projects,
            'emptyProjects' => $emptyProjects
        );

        return View::make('volunteer/project/list')->with($data);

    }
    public function findMyCsrProjects()
    {

        $this->volunteer = Volunteer::where('user_id', '=', Auth::id())->first();

        $projects = Project::whereNull('ngo_id')->whereHas('volunteers', function ($q) {
            $q->where('volunteer_id', 'like', $this->volunteer->id);
        })->paginate(4);

        $emptyProjects = false;
        if ($projects->getTotal() == 0) {
            $emptyProjects = true;
        }
        $isCsr = true;
        $data = array(
            'projects' => $projects,
            'emptyProjects' => $emptyProjects,
            'isCsr' => $isCsr
        );

        return View::make('volunteer/project/list')->with($data);

    }
}