<?php

class MessageController extends BaseController
{
    protected $columDatabase;
    protected $eloquentRecipient;
    protected $message;

    protected $user;

    public function __construct()
    {
        parent::__construct();
    }

    public function getInbox()
    {
        $this->user = Auth::user();
        $this->columDatabase = null;

        if ($this->user == null) {
            return Redirect::to('/')->with('error', Lang::get('messages.listMessage.errorNotLogged'));
        }

        if ($this->user->hasRole('VOLUNTEER')) {

            $this->columDatabase = 'recipient_volunteer_id';
            $this->eloquentRecipient = 'recipients_volunteer';
            $this->user = Volunteer::where('user_id', '=', Auth::id())->first();


        } elseif ($this->user->hasRole('NonGovernmentalOrganization')) {

            $this->columDatabase = 'recipient_ngo_id';
            $this->eloquentRecipient = 'recipients_ngo';
            $this->user = Ngo::where('user_id', '=', Auth::id())->first();


        } elseif ($this->user->hasRole('ADMINISTRATOR')) {

            $this->columDatabase = 'recipient_administrator_id';
            $this->eloquentRecipient = 'recipients_administrator';
            $this->user = Administrator::where('user_id', '=', Auth::id())->first();


        } elseif ($this->user->hasRole('COMPANY')) {

            $this->columDatabase = 'recipient_company_id';
            $this->eloquentRecipient = 'recipients_company';
            $this->user = Company::where('user_id', '=', Auth::id())->first();


        }
        $messages = Message::whereHas($this->eloquentRecipient, function ($q) {
            $q->where($this->columDatabase, '=', $this->user->id);
        })->paginate(4);

        $messagesNotRead = Message::whereHas($this->eloquentRecipient, function ($q) {
            $q->where($this->columDatabase, '=', $this->user->id)->where('read', '=', false);
        })->get();

        $messagesNotReadId = array();
        if (!$messagesNotRead->isEmpty()) {
            foreach ($messagesNotRead as $message) {
                $messagesNotReadId[] = $message->id;
            }
        }

        $emptyMessages = false;
        $inbox = true;

        if ($messages->getTotal() == 0) {
            $emptyMessages = true;
        }
        return View::make('site/message/list', compact('messages', 'messagesNotReadId', 'emptyMessages', 'inbox'));

    }

    public function getSent()
    {
        $user = Auth::user();
        if ($user == null) {
            return Redirect::to('/')->with('error', Lang::get('messages.listMessage.errorNotLogged'));
        }

        $columDatabase = null;
        if ($user->hasRole('VOLUNTEER')) {
            $columDatabase = 'volunteer_id';
            $user = Volunteer::where('user_id', '=', Auth::id())->first();
        } elseif ($user->hasRole('NonGovernmentalOrganization')) {
            $columDatabase = 'ngo_id';
            $user = Ngo::where('user_id', '=', Auth::id())->first();

        } elseif ($user->hasRole('ADMINISTRATOR')) {
            $columDatabase = 'administrator_id';
            $user = Administrator::where('user_id', '=', Auth::id())->first();


        } elseif ($user->hasRole('COMPANY')) {
            $columDatabase = 'company_id';
            $user = Company::where('user_id', '=', Auth::id())->first();

        }

        $messages = Message::where($columDatabase, '=', $user->id)->paginate(6);
        $emptyMessages = false;
        $inbox = false;

        if ($messages->getTotal() == 0) {
            $emptyMessages = true;
        }
        return View::make('site/message/list', compact('messages', 'emptyMessages', 'inbox'));

    }

    public function view($id)
    {
        $this->user = Auth::user();
        if ($this->user == null) {
            return Redirect::to('/')->with('error', Lang::get('messages.viewMessage.errorNotLogged'));
        }

        $this->message = Message::where('id', '=', $id)->first();
        $messageAux = null;
        $idColum = null;

        if ($this->user->hasRole('VOLUNTEER')) {

            $this->columDatabase = 'recipient_volunteer_id';
            $this->eloquentRecipient = 'recipients_volunteer';
            $this->user = Volunteer::where('user_id', '=', Auth::id())->first();
            $idColum = $this->message->volunteer_id;

        } elseif ($this->user->hasRole('NonGovernmentalOrganization')) {

            $this->columDatabase = 'recipient_ngo_id';
            $this->eloquentRecipient = 'recipients_ngo';
            $this->user = Ngo::where('user_id', '=', Auth::id())->first();
            $idColum = $this->message->ngo_id;

        } elseif ($this->user->hasRole('ADMINISTRATOR')) {

            $this->columDatabase = 'recipient_administrator_id';
            $this->eloquentRecipient = 'recipients_administrator';
            $this->user = Administrator::where('user_id', '=', Auth::id())->first();
            $idColum = $this->message->administrator_id;

        } elseif ($this->user->hasRole('COMPANY')) {

            $this->columDatabase = 'recipient_company_id';
            $this->eloquentRecipient = 'recipients_company';
            $this->user = Company::where('user_id', '=', Auth::id())->first();
            $idColum = $this->message->company_id;
        }
        $messageAuxNotRead=null;
        if ($this->user->id != $idColum) {
            //Si no es enviado, hay que comprobar si es recibido
            $messageAuxNotRead = Message::whereHas($this->eloquentRecipient, function ($q) {
                $q->where($this->columDatabase, '=', $this->user->id)->where('message_id', '=', $this->message->id)->where('read', '=', false);
            })->first();
            $messageAuxRead = Message::whereHas($this->eloquentRecipient, function ($q) {
                $q->where($this->columDatabase, '=', $this->user->id)->where('message_id', '=', $this->message->id)->where('read', '=', true);
            })->first();
            if ($messageAuxNotRead == null && $messageAuxRead == null) {
                return Redirect::to('/')->with('error', Lang::get('messages.viewMessage.errorHisMessage'));
            }
        }


        if ($messageAuxNotRead != null) {
            $transaction = DB::table('message_recipient')->where('message_id','=', $messageAuxNotRead->id)->where($this->columDatabase,'=', $this->user->id)->update(array('read' => true));
            if ($transaction) {
                $backUrl = Session::get('backUrl');
                return View::make('site/message/view')->with('message', $this->message)->with('backUrl', $backUrl);
            }
            return Redirect::to('/')->with('error', Lang::get('messages.viewMessage.error'));
        } else {
            $backUrl = Session::get('backUrl');
            return View::make('site/message/view')->with('message', $this->message)->with('backUrl', $backUrl);
        }
    }
}