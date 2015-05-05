<?php


class CompanyProjectController extends BaseController
{

    protected $project;

    public function __construct(Project $project)
    {
        parent::__construct();
        $this->project = $project;
    }
    public function findMyCsrProjects()
    {


        $company = Company::where('user_id', '=',  Auth::id())->first();

        $projects = Project::where("company_id", '=', $company->id)->paginate(4);
        $emptyProjects = false;
        if ($projects->getTotal()==0) {
            $emptyProjects = true;
        }

        $data = array(

            'viewCsrMyProjects' => true,
            'projects' => $projects,
            'emptyProjects' => $emptyProjects
        );

        return View::make('company/project/list')->with($data);


    }
    public function createCsrProject()
    {
        $title = Lang::get('project/create.titleCreateCsrProject');
        // Show the page
        $categories = Category::all();
        return View::make('site/project/createProject', compact('categories','title'));
    }


    public function saveCsrProject()
    {
        $user = Auth::user();
        $company = Company::where('user_id', '=', $user->id)->first();

        if (!$company->active) {
            return Redirect::to('/')->with('error', Lang::get('project/messages.createCsr.errorNotActive'));
        }
        if ($company->banned) {
            return Redirect::to('/')->with('error', Lang::get('project/messages.createCsr.errorBanned'));
        }
        // Declare the rules for the form validation
        $rules = array(
            'name' => 'required|min:4',
            'description' => 'required|min:10',
            'city' => 'required|alpha|min:4',
            'country' => 'required|alpha|min:4',
            'zipCode' => 'required|integer|min:0',
            'maxVolunteers' => 'required|integer|min:0',
            'startDate' => 'required|date|after:"now"',
            'finishDate' => 'required|date|after:startDate',
            'categories' => 'required|array|min:1',
            'logo'          => 'image',

        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes()) {

            // Update the blog post data
            $this->project->name = Input::get('name');
            $this->project->description = Input::get('description');
            $this->project->address = Input::get("address");
            $this->project->city = Input::get("city");
            $this->project->zipCode = Input::get("zipCode");
            $this->project->maxVolunteers = Input::get("maxVolunteers");
            $this->project->country = Input::get("country");
            $this->project->startDate = Input::get("startDate");
            $this->project->finishDate = Input::get("finishDate");
            $this->project->created_at = date("Y-m-d");


            //asignandole el id
            $this->project->company_id = $company->id;

            $destinationPath = public_path() . '/logos/' . $user->email;

            $image = Input::file('image');
            if ($image != null) {

                $filename = $image->getClientOriginalName();
                $image->move($destinationPath, $filename);
                $this->project->image = '/logos/' . $user->email . '/' . $filename;

            }else{
                $this->project->image ='/logos/imageNotFound.gif';
            }

            // Was the blog post created?
            if ($this->project->save()) {
                //una vez salvado ya tenemos generado el id necesario para la tabla pivote en las relaciones con las categorias
                if ($this->project->id) {
                    $categories = Input::get('categories');
                    $this->project->categories()->attach($categories);
                }

                // Redirect to the new blog post page
                return Redirect::to('company/project/myCsrProjects')->with('success', Lang::get('project/messages.createCsr.success'));
            }

            // Redirect to the blog post create page
            return Redirect::to('company/project/createCsrProject')->with('error', Lang::get('project/messages.createCsr.error'));
        }

        // Form validation failed
        return Redirect::to('company/project/createCsrProject')->withInput()->withErrors($validator);
    }


    public function editGetCsrProject($id)
    {
        $title = Lang::get('project/create.editTitleProject');
        $company = Company::where('user_id', '=', Auth::id())->first();

        $projectOld = Project::where("id", '=', $id)->first();

        //checkeamos que no haya applications pendientes ni voluntarios ya asociados
        if ($projectOld->company_id != $company->id) {
            return Redirect::to('projectCsr/view/' . $id)->with('error', Lang::get('project/messages.editCsr.errorNotHisProject'));

        }
        $volunteers = $projectOld->volunteers;
        if (sizeof($volunteers) > 0) {
            return Redirect::to('projectCsr/view/' . $id)->with('error', Lang::get('project/messages.editCsr.errorWithVolunteer'));
        }


        $applications = $projectOld->applications;
        if (sizeof($applications) > 0) {
            foreach ($projectOld->applications as $application) {
                if ($application->result != 2) {//es decir si hay application no contestadas o contestadas positivamente
                    return Redirect::to('projectCsr/view/' . $id)->with('error', Lang::get('project/messages.editCsr.errorWithApplications'));
                }
            }
        }

        if (!$company->active) {
            return Redirect::to('projectCsr/view/' . $id)->with('error', Lang::get('project/messages.editCsr.errorNotActive'));
        }
        if ($company->banned) {
            return Redirect::to('projectCsr/view/' . $id)->with('error', Lang::get('project/messages.editCsr.errorBanned'));
        }
        $categories = Category::all();

        $data = array(

            'categories' => $categories,
            'project' => $projectOld,
            'title' => $title
        );
        return View::make('site/project/createProject')->with($data);


    }

    public function deleteCsrProject($id)
    {

        $company = Company::where('user_id', '=', Auth::id())->first();

        $projectOld = Project::where("id", '=', $id)->first();

        //checkeamos que no haya applications pendientes ni voluntarios ya asociados
        if ($projectOld->company_id != $company->id) {
            return Redirect::to('projectCsr/view/' . $id)->with('error', Lang::get('project/messages.deleteCsr.errorNotHisProject'));

        }
        if (sizeof($projectOld->volunteers) > 0) {
            return Redirect::to('projectCsr/view/' . $id)->with('error', Lang::get('project/messages.deleteCsr.errorWithVolunteer'));
        }
        if (sizeof($projectOld->applications) > 0) {
            foreach ($projectOld->applications as $application) {
                if ($application->result != 2) {//es decir si hay application no contestadas o contestadas positivamente
                    return Redirect::to('projectCsr/view/' . $id)->with('error', Lang::get('project/messages.deleteCsr.errorWithApplications'));
                }
            }
        }

        if (!$company->active) {
            return Redirect::to('projectCsr/view/' . $id)->with('error', Lang::get('project/messages.deleteCsr.errorNotActive'));
        }
        if ($company->banned) {
            return Redirect::to('projectCsr/view/' . $id)->with('error', Lang::get('project/messages.deleteCsr.errorBanned'));
        }

        if ($projectOld->delete()) {
              return Redirect::to('company/project/myCsrProjects')->with('success', Lang::get('project/messages.deleteCsr.success'));

        }
        return Redirect::to('company/project/myCsrProjects')->with('error', Lang::get('project/messages.deleteCsr.error'));

    }




    public function editSaveCsrProject($id)
    {


        $user = Auth::user();
        $company = Company::where('user_id', '=', $user->id)->first();

        $projectOld = Project::where("id", '=', $id)->first();

        //checkeamos que no haya applications pendientes ni voluntarios ya asociados
        if ($projectOld->company_id != $company->id) {
            return Redirect::to('projectCsr/view/' . $id)->with('error', Lang::get('project/messages.editCsr.errorNotHisProject'));

        }
        if (sizeof($projectOld->volunteers) > 0) {
            return Redirect::to('projectCsr/view/' . $id)->with('error', Lang::get('project/messages.editCsr.errorWithVolunteer'));
        }
        if (sizeof($projectOld->applications) > 0) {
            foreach ($projectOld->applications as $application) {
                if ($application->result != 2) {//es decir si hay application no contestadas o contestadas positivamente
                    return Redirect::to('projectCsr/view/' . $id)->with('error', Lang::get('project/messages.editCsr.errorWithApplications'));
                }
            }
        }

        if (!$company->active) {
            return Redirect::to('projectCsr/view/' . $id)->with('error', Lang::get('project/messages.editCsr.errorNotActive'));
        }
        if ($company->banned) {
            return Redirect::to('projectCsr/view/' . $id)->with('error', Lang::get('project/messages.editCsr.errorBanned'));
        }
        // Declare the rules for the form validation
        $rules = array(
            'name' => 'required|min:4',
            'description' => 'required|min:10',
            'city' => 'required|alpha|min:4',
            'country' => 'required|alpha|min:4',
            'zipCode' => 'required|integer|min:0',
            'maxVolunteers' => 'required|integer|min:0',
            'startDate' => 'required|date|after:"now"',
            'finishDate' => 'required|date|after:startDate',
            'categories' => 'required|array|min:1',
            'logo'          => 'image',

        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes()) {

            // Update the blog post data
            $projectOld->name = Input::get('name');
            $projectOld->description = Input::get('description');
            $projectOld->address = Input::get("address");
            $projectOld->city = Input::get("city");
            $projectOld->zipCode = Input::get("zipCode");
            $projectOld->maxVolunteers = Input::get("maxVolunteers");
            $projectOld->country = Input::get("country");
            $projectOld->startDate = Input::get("startDate");
            $projectOld->finishDate = Input::get("finishDate");
            $projectOld->created_at = $projectOld->create_at;
            $projectOld->updated_at = date("Y-m-d");


            $destinationPath = public_path() . '/logos/' . $user->email;

            $image = Input::file('image');
            if ($image != null) {

                $filename = $image->getClientOriginalName();
                $image->move($destinationPath, $filename);
                $projectOld->image = '/logos/' . $user->email . '/' . $filename;

            }

            // usamos push ya que save no guarda los cambios en las relaciones


            if ($projectOld->save()) {
                $categories = Input::get('categories');
                //se usa sync, ya que este reemplaza todas las relaciones manyToMany por las nuevas, attach las añade a las anteriores
                $projectOld->categories()->sync($categories);
                return Redirect::to('company/project/myCsrProjects')->with('success', Lang::get('project/messages.editCsr.success'));

            }
            return Redirect::to('company/project/editCsrProject/' . $id)->with('error', Lang::get('project/messages.editCsr.error'));

            // Redirect to the new blog post page
        }


        // Form validation failed
        return Redirect::to('company/project/editCsrProject/' . $id)->withInput()->withErrors($validator);
    }
}