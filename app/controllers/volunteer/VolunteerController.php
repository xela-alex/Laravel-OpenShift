<?php

class VolunteerController extends BaseController {

    /**
     * User Model
     * @var User
     */
    protected $volunteer;
    protected $user;
    /**
     * Inject the models.
     * @param User $user
     */
    public function __construct(Volunteer $volunteer, User $user)
    {
        parent::__construct();
        $this->volunteer = $volunteer;
        $this->user = $user;
    }

    /**
     * Users settings page
     *
     * @return View
     */
    public function getIndex()
    {
        list($user,$redirect) = $this->user->checkAuthAndRedirect('userVolunteer');
        if($redirect){return $redirect;}
        $volunteer = $this->volunteer;
        // Show the page
        return View::make('site/volunteer/index', compact('volunteer'));
    }

    /**
     * Stores new user
     *
     */

    public function postIndex()
    {

        $rules = array(
            'name'    => 'required|min:3',
            'surname' => 'required|min:3',
            'city'    => 'required|min:3',
            'zipCode' => 'required|min:3',
            'country' => 'required|min:3'
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success


        $this->user->username = Input::get( 'username' );
        $this->user->email = Input::get( 'email' );
        $this->volunteer->name = Input::get("name");
        $this->volunteer->surname = Input::get("surname");
        $this->volunteer->address = Input::get("address");
        $this->volunteer->city = Input::get("city");
        $this->volunteer->zipCode = Input::get("zipCode");
        $this->volunteer->country = Input::get("country");
        $this->volunteer->biography = Input::get("biography");
        $password = Input::get( 'password' );
        $passwordConfirmation = Input::get( 'password_confirmation' );

        if(!empty($password)) {
            if($password === $passwordConfirmation) {
                $this->user->password = $password;
                // The password confirmation will be removed from model
                // before saving. This field will be used in Ardent's
                // auto validation.
                $this->user->password_confirmation = $passwordConfirmation;
            } else {
                // Redirect to the new user page
                return Redirect::to('userVolunteer/create')
                    ->withInput(Input::except('password','password_confirmation'))
                    ->with('error', Lang::get('admin/users/messages.password_does_not_match'));
            }
        } else {
            unset($this->user->password);
            unset($this->user->password_confirmation);
        }

        if ($validator->passes()) {

        // Save if valid. Password field will be hashed before save

            $this->user->save();
            if ( $this->user->id )
            {
                $this->user->attachRole( Role::where('name','=','VOLUNTEER')->first());
                $this->volunteer->user_id = $this->user->id;
                    $this->volunteer->save();

                    // Redirect with success message, You may replace "Lang::get(..." for your custom message.
                    return Redirect::to('user/login')
                        ->with('success', Lang::get('user/user.user_account_created'));

            }
            else
            {
                // Get validation errors (see Ardent package)
                $error = $this->user->errors()->all();

                return Redirect::to('userVolunteer/create')
                    ->withInput(Input::except('password'))
                    ->with( 'error', $error );
            }
        }
        else{
            return Redirect::to('userVolunteer/create')
                ->withInput(Input::except('password'))
                ->withErrors($validator);
        }
    }

    /**
     * Edits a user
     *
     */
    public function postEdit($user)
    {
        // Validate the inputs
        $validator = Validator::make(Input::all(), $user->getUpdateRules());


        if ($validator->passes())
        {
            $oldUser = clone $user;
            $user->username = Input::get( 'username' );
            $user->email = Input::get( 'email' );

            $password = Input::get( 'password' );
            $passwordConfirmation = Input::get( 'password_confirmation' );

            if(!empty($password)) {
                if($password === $passwordConfirmation) {
                    $user->password = $password;
                    // The password confirmation will be removed from model
                    // before saving. This field will be used in Ardent's
                    // auto validation.
                    $user->password_confirmation = $passwordConfirmation;
                } else {
                    // Redirect to the new user page
                    return Redirect::to('users')->with('error', Lang::get('admin/users/messages.password_does_not_match'));
                }
            } else {
                unset($user->password);
                unset($user->password_confirmation);
            }

            $user->prepareRules($oldUser, $user);

            // Save if valid. Password field will be hashed before save
            $user->amend();
        }

        // Get validation errors (see Ardent package)
        $error = $user->errors()->all();

        if(empty($error)) {
            return Redirect::to('user')
                ->with( 'success', Lang::get('user/user.user_account_updated') );
        } else {
            return Redirect::to('user')
                ->withInput(Input::except('password','password_confirmation'))
                ->with( 'error', $error );
        }
    }

    /**
     * Displays the form for user creation
     *
     */
    public function getCreate()
    {
        return View::make('site/volunteer/create');
    }



}
