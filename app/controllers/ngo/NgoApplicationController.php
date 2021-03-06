<?php

class NgoApplicationController extends BaseController
{

    protected $ngo;


    public function __construct(Application $application)
    {
        parent::__construct();
        $this->application = $application;
    }

    public function findOurAnsweredApplications()
    {
        $title=Lang::get('application/list.titleAnswered');
        $this->ngo=Ngo::where('user_id','=',Auth::id())->first();

        $applications = Application::where('result','>',0)->whereHas('project', function ($q) {$q->where('ngo_id','=', $this->ngo->id);})
            ->paginate(4);

        $data = array(
            'applications' => $applications,
            'title' => $title,
        );
        Return View::make('site/application/list')->with($data);
    }

    public function findOurPendingApplications()
    {
        $title=Lang::get('application/list.titlePending');
        $this->ngo=Ngo::where('user_id','=',Auth::id())->first();

        $applications = Application::where('result','=',0)->whereHas('project', function ($q) {$q->where('ngo_id','=', $this->ngo->id);})
            ->paginate(4);

        $data = array(
            'applications' => $applications,
            'title' => $title,
        );
        Return View::make('site/application/list')->with($data);
    }

    public function viewApplication($id)
    {
        $application = Application::where('id', '=', $id)->first();


        if ($application->result==0) {
            $backUrl = 'ngo/application/pending';

        } else {
            $backUrl = 'ngo/application/answered';
        }

        $data = array(
            'backUrl' => $backUrl,
            'application' => $application,
        );
        Return View::make('site/application/view')->with($data);
    }

    public function answer($id,$answer){
        $application = Application::where('id', '=', $id)->first();
        $ngo=Ngo::where('user_id','=',Auth::id())->first();
        $backUrl='ngo/application/view/'.$id;

        if($application->project->ngo_id!=$ngo->id){
            return Redirect::to($backUrl)->with('error', Lang::get('application/messages.answer.errorNotHisProject'));
        }
        if($application->result!=0){
            return Redirect::to($backUrl)->with('error', Lang::get('application/messages.answer.errorAnsweredYet'));
        }

        if($answer==1 || $answer==2){

            $application->result=$answer;

        }else{
            return Redirect::to($backUrl)->with('error', Lang::get('application/messages.answer.errorRequest'));
        }

        if($application->save()){
            if($application->result==2){

                $project=Project::where('id','=',$application->project_id)->first();
                $volunteer=Volunteer::where('id','=',$application->volunteer_id)->first();

                $project->volunteers()->attach($volunteer);
            }
            return Redirect::to('ngo/application/answered')->with('success', Lang::get('application/messages.answer.success'));
        }

        return Redirect::to($backUrl)->with('error', Lang::get('application/messages.answer.error'));
    }
}