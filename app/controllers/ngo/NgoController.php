<?php

class NgoController extends BaseController
{

    /**
     * User Model
     * @var User
     */
    protected $ngo;
    protected $user;


    /**
     * Inject the models.
     * @param User $user
     */
    public function __construct(Ngo $ngo, User $user)
    {
        parent::__construct();
        $this->ngo = $ngo;
        $this->user = $user;
    }

    /**
     * Users settings page
     *
     * @return View
     */
    public function getIndex()
    {
        list($user, $redirect) = $this->user->checkAuthAndRedirect('ngo');
        if ($redirect) {
            return $redirect;
        }
        $ngo = $this->ngo;
        // Show the page
        return View::make('site/ngo/index', compact('ngo'));
    }

    /**
     * Stores new user
     *
     */

    public function postIndex()
    {

        $rules = array(
            'holderName' => 'required|min:3',
            'brandName' => 'required|min:3',
            'number' => array('required', 'Regex:/^([4]{1})([0-9]{12,15})$/'),//visa
            'expirationMonth' => 'required|integer|between:1,12',
            'expirationYear' => 'required|integer|min:2014',
            'cvv' => 'required|integer|between:100,999',
            'description' => 'required|min:3',
            'phone' => array('required', 'Regex:/^\d+$/')


        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success


        $this->user->username = Input::get('username');
        $this->user->email = Input::get('email');
        $this->ngo->name = Input::get("name");
        $this->ngo->holderName = Input::get("holderName");
        $this->ngo->brandName = Input::get("brandName");
        $this->ngo->number = Input::get("number");
        $this->ngo->expirationMonth = Input::get("expirationMonth");
        $this->ngo->expirationYear = Input::get("expirationYear");
        $this->ngo->cvv = Input::get("cvv");
        $this->ngo->description = Input::get("description");
        $this->ngo->phone = Input::get("phone");


        $destinationPath = public_path().'/logos/'.$this->user->email;


        //Active y Banned no hace falta ponerlos, en la base de datos van por defecto a falso

        $password = Input::get('password');
        $passwordConfirmation = Input::get('password_confirmation');

        if (!empty($password)) {
            if ($password === $passwordConfirmation) {
                $this->user->password = $password;
                // The password confirmation will be removed from model
                // before saving. This field will be used in Ardent's
                // auto validation.
                $this->user->password_confirmation = $passwordConfirmation;
            } else {
                // Redirect to the new user page
                return Redirect::to('userNgo/create')
                    ->withInput(Input::except('password', 'password_confirmation'))
                    ->with('error', Lang::get('admin/users/messages.password_does_not_match'));
            }
        } else {
            unset($this->user->password);
            unset($this->user->password_confirmation);
        }

        if ($validator->passes()) {

            // Save if valid. Password field will be hashed before save


            $this->user->save();//al guardar se generara el id
            //tenemos que coger el usuario de la base de datos puesto que este aun no tiene el id
            //$this->usuarioSalvado = (User::where('email', '=', $this->user->email)->first());
            if ($this->user->id) {
                $this->user->attachRole(Role::where('name', '=', 'NonGovernmentalOrganization')->first());
                $this->ngo->user_id = $this->user->id;

                //si pasa la validacion se guarda la imagen, si es que han subido alguna

                $logo = Input::file('logo');
                if ($logo != null) {

                    $filename = $logo->getClientOriginalName();
                    $logo->move($destinationPath, $filename);
                    $this->ngo->logo =  '/logos/'.$this->user->email .'/'. $filename;

                }
                $this->ngo->save();

                // Redirect with success message, You may replace "Lang::get(..." for your custom message.
                return Redirect::to('user/login')
                    ->with('success', Lang::get('user/user.user_account_created'));

            } else {
                // Get validation errors (see Ardent package)
                $error = $this->user->errors()->all();

                return Redirect::to('userNgo/create')
                    ->withInput(Input::except('password'))
                    ->with('error', $error);
            }
        } else {
            return Redirect::to('userNgo/create')
                ->withInput(Input::except('password'))
                ->withErrors($validator);
        }
    }

    /**
     * Edits a user
     *
     */
    public
    function postEdit($user)
    {
        // Validate the inputs
        $validator = Validator::make(Input::all(), $user->getUpdateRules());


        if ($validator->passes()) {
            $oldUser = clone $user;
            $user->username = Input::get('username');
            $user->email = Input::get('email');

            $password = Input::get('password');
            $passwordConfirmation = Input::get('password_confirmation');

            if (!empty($password)) {
                if ($password === $passwordConfirmation) {
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

        if (empty($error)) {
            return Redirect::to('user')
                ->with('success', Lang::get('user/user.user_account_updated'));
        } else {
            return Redirect::to('user')
                ->withInput(Input::except('password', 'password_confirmation'))
                ->with('error', $error);
        }
    }

    /**
     * Displays the form for user creation
     *
     */
    public
    function getCreate()
    {
        return View::make('site/ngo/create');
    }


    /**
     * Displays the login form
     *
     */
    public
    function getLogin()
    {
        $user = Auth::user();
        if (!empty($user->id)) {
            return Redirect::to('/');
        }

        return View::make('site/user/login');
    }

    /**
     * Attempt to do login
     *
     */
    public
    function postLogin()
    {
        $input = array(
            'email' => Input::get('email'), // May be the username too
            'username' => Input::get('email'), // May be the username too
            'password' => Input::get('password'),
            'remember' => Input::get('remember'),
        );

        // If you wish to only allow login from confirmed users, call logAttempt
        // with the second parameter as true.
        // logAttempt will check if the 'email' perhaps is the username.
        // Check that the user is confirmed.
        if (Confide::logAttempt($input, true)) {
            return Redirect::intended('/');
        } else {
            // Check if there was too many login attempts
            if (Confide::isThrottled($input)) {
                $err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
            } elseif ($this->user->checkUserExists($input) && !$this->user->isConfirmed($input)) {
                $err_msg = Lang::get('confide::confide.alerts.not_confirmed');
            } else {
                $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
            }

            return Redirect::to('user/login')
                ->withInput(Input::except('password'))
                ->with('error', $err_msg);
        }
    }

    /**
     * Attempt to confirm account with code
     *
     * @param  string $code
     */
    public
    function getConfirm($code)
    {
        if (Confide::confirm($code)) {
            return Redirect::to('user/login')
                ->with('notice', Lang::get('confide::confide.alerts.confirmation'));
        } else {
            return Redirect::to('user/login')
                ->with('error', Lang::get('confide::confide.alerts.wrong_confirmation'));
        }
    }

    /**
     * Displays the forgot password form
     *
     */
    public
    function getForgot()
    {
        return View::make('site/user/forgot');
    }

    /**
     * Attempt to reset password with given email
     *
     */
    public
    function postForgot()
    {
        if (Confide::forgotPassword(Input::get('email'))) {
            return Redirect::to('user/login')
                ->with('notice', Lang::get('confide::confide.alerts.password_forgot'));
        } else {
            return Redirect::to('user/forgot')
                ->withInput()
                ->with('error', Lang::get('confide::confide.alerts.wrong_password_forgot'));
        }
    }

    /**
     * Shows the change password form with the given token
     *
     */
    public
    function getReset($token)
    {

        return View::make('site/user/reset')
            ->with('token', $token);
    }


    /**
     * Attempt change password of the user
     *
     */
    public
    function postReset()
    {
        $input = array(
            'token' => Input::get('token'),
            'password' => Input::get('password'),
            'password_confirmation' => Input::get('password_confirmation'),
        );

        // By passing an array with the token, password and confirmation
        if (Confide::resetPassword($input)) {
            return Redirect::to('user/login')
                ->with('notice', Lang::get('confide::confide.alerts.password_reset'));
        } else {
            return Redirect::to('user/reset/' . $input['token'])
                ->withInput()
                ->with('error', Lang::get('confide::confide.alerts.wrong_password_reset'));
        }
    }

    /**
     * Log the user out of the application.
     *
     */
    public
    function getLogout()
    {
        Confide::logout();

        return Redirect::to('/');
    }

    /**
     * Get user's profile
     * @param $username
     * @return mixed
     */
    public
    function getProfile($username)
    {
        $userModel = new User;
        $user = $userModel->getUserByUsername($username);

        // Check if the user exists
        if (is_null($user)) {
            return App::abort(404);
        }

        return View::make('site/user/profile', compact('user'));
    }

    public
    function getSettings()
    {
        list($user, $redirect) = User::checkAuthAndRedirect('user/settings');
        if ($redirect) {
            return $redirect;
        }

        return View::make('site/user/profile', compact('user'));
    }

    /**
     * Process a dumb redirect.
     * @param $url1
     * @param $url2
     * @param $url3
     * @return string
     */
    public
    function processRedirect($url1, $url2, $url3)
    {
        $redirect = '';
        if (!empty($url1)) {
            $redirect = $url1;
            $redirect .= (empty($url2) ? '' : '/' . $url2);
            $redirect .= (empty($url3) ? '' : '/' . $url3);
        }
        return $redirect;
    }
}
