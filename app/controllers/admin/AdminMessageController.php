<?php

class AdminMessageController extends BaseController
{
    protected $message;
    public function __construct(Message $message)
    {
        parent::__construct();
        $this->message = $message;
    }

    public function createMessage($id)
    {
        $backUrl = Session::get('backUrl');
        $action = 'admin/message/sendMessage';

        $data = array(
            'user_id'           => $id,
            'backUrl'           => $backUrl,
            'sendMessageAction' => $action,
        );

        Return View::make('admin/message/send')->with($data);
    }

    public function sendMessage()
    {
        // Declare the rules for the form validation
        $rules = array(
            'subject' => 'required|min:1',
            'textBox' => 'required|min:1',
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes()) {
            $this->message->subject = Input::get('subject');
            $this->message->textBox = Input::get('textBox');
            $this->message->from = Lang::get('admin/message.adminFromField');
            $this->message->date = new DateTime('now');
            $this->message->administrator_id = Administrator::where('user_id', '=', Auth::id())->first()->id;

            $recipientUserVolunteer = Volunteer::where('user_id', '=', Input::get('user_id'))->first();
            $recipientUserCompany = Company::where('user_id', '=', Input::get('user_id'))->first();
            $recipientUserNGO = Ngo::where('user_id', '=', Input::get('user_id'))->first();

            if($this->message->save())
            {
                if($this->message->id)
                {
                    if($recipientUserCompany)
                    {
                        Message::where('id', '=', $this->message->id)->update(array('to' => $recipientUserCompany->name));
                        $this->message->recipients_company()->attach($recipientUserCompany);
                    }

                    if($recipientUserVolunteer)
                    {
                        Message::where('id', '=', $this->message->id)->update(array('to' => $recipientUserVolunteer->name.' '.$recipientUserVolunteer->surname));
                        $this->message->recipients_volunteer()->attach($recipientUserVolunteer);
                    }

                    if($recipientUserNGO)
                    {
                        Message::where('id', '=', $this->message->id)->update(array('to' => $recipientUserNGO->name));
                        $this->message->recipients_ngo()->attach($recipientUserNGO);
                    }
                }

            }

            return Redirect::to(Session::get('backUrl'))->with('success', Lang::get('admin/message.successfullySent'));
        }
        else
            return Redirect::to('admin/message/send')->withInput()->withErrors($validator);

    }

    public function createGlobalMessage()
    {
        $backUrl = Session::get('backUrl');
        $action = 'admin/message/broadcastMessage';

        $data = array(
            'backUrl'           => $backUrl,
            'sendMessageAction' => $action,
        );

        Return View::make('admin/message/send')->with($data);
    }

    public function broadcastMessage()
    {
        // Declare the rules for the form validation
        $rules = array(
            'type'    => array('required', 'regex:/NGOs|companies|volunteers/'),
            'subject' => 'required|min:1',
            'textBox' => 'required|min:1',
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes()) {
            $this->message->subject = Input::get('subject');
            $this->message->textBox = Input::get('textBox');
            $this->message->from = Lang::get('admin/message.adminFromField');
            $this->message->date = new DateTime('now');
            $this->message->administrator_id = Administrator::where('user_id', '=', Auth::id())->first()->id;
            $recipients = null;

            if(Input::get('type') == 'NGOs')
            {
                $this->message->to = Lang::get('admin/message.adminToFieldBroadcastNGOs');
                $recipients = Ngo::all();
            }
            if(Input::get('type') == 'companies')
            {
                $this->message->to = Lang::get('admin/message.adminToFieldBroadcastCompanies');
                $recipients = Company::all();
            }
            if(Input::get('type') == 'volunteers')
            {
                $this->message->to = Lang::get('admin/message.adminToFieldBroadcastVolunteers');
                $recipients = Volunteer::all();
            }

            if($this->message->save())
            {
                if($this->message->id)
                {
                    foreach($recipients as $recipient)
                    {
                        if(Input::get('type') == 'NGOs')
                        {
                            $this->message->recipients_ngo()->attach($recipient);
                        }
                        if(Input::get('type') == 'companies')
                        {
                            $this->message->recipients_company()->attach($recipient);
                        }
                        if(Input::get('type') == 'volunteers')
                        {
                            $this->message->recipients_volunteer()->attach($recipient);
                        }
                    }
                }

            }

            return Redirect::to('/')->with('success', Lang::get('admin/message.successfullySent'));
        }
        else
            return Redirect::to('admin/message/broadcastMessage')->withInput()->withErrors($validator);

    }

}