<?php

class NgoCampaignController extends BaseController
{
    public function __construct(Campaign $campaign)
    {
        parent::__construct();
        $this->campaign = $campaign;
    }

    public function findCampaignsByCurrentNGO()
    {
        if(Auth::check() && Auth::user()->hasRole('NonGovernmentalOrganization'))
        {
            $user = Auth::user();
            $ngo = Ngo::where('user_id','=',$user->id)->first();
            $campaigns = Campaign::where('ngo_id','=',$ngo->id)->paginate(3);

            $data = array(
                'campaigns' => $campaigns,
            );

            Return View::make('site/campaign/list')->with($data);
        }
        else
        {
            Return Redirect::to('/');
        }
    }

    public function createCampaign()
    {
        $backUrl=  Session::get('backUrl');

        $data = array(
            'backUrl'=>$backUrl
        );

        Return View::make('site/campaign/create')->with($data);
    }

    public function saveCampaign()
    {
        $rules = array(
            'name'                  => 'required|min:3',
            'description'           => 'required|min:3',
            'image'                 => 'required|image',
            'startDate'             => 'required|date|after:'.date('Y-m-d').'|before:'.Input::get('finishDate'),
            'finishDate'            => 'required|date|after:'.date('Y-m-d'),
            'link'                  => 'required|url',
            'maxVisits'             => 'required|min:0',
            'promotionDuration'     => 'required|min:1',
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        $this->campaign->name = Input::get( 'name' );
        $this->campaign->description = Input::get( 'description' );
        $this->campaign->startDate = Input::get( 'startDate' );
        $this->campaign->finishDate = Input::get( 'finishDate' );
        $this->campaign->link = Input::get( 'link' );
        $this->campaign->promotionDuration = Input::get( 'promotionDuration' );
        $this->campaign->ngo_id = Ngo::where('user_id','=',Auth::id())->first()->id;

        $destinationPath = public_path().'/campaigns_images/'.$this->campaign->name;

        if ($validator->passes())
        {
            $image = Input::file('image');
            $filename = $image->getClientOriginalName();
            $image->move($destinationPath, $filename);
            $this->campaign->image =  '/campaigns_images/'.$this->campaign->name .'/'. $filename;

            $this->campaign->save();

            return Redirect::to('ngo/myCampaigns')->with('success', Lang::get('campaign/campaign.creationSuccessful'));
        }
        else
        {
            return Redirect::to('ngo/campaign/create')->withInput(Input::all())->withErrors($validator);
        }
    }
    public function sendEmails()
    {
        $curl = curl_init('http://10code.ip-zone.com//ccm/admin/api/version/2/&type=json');

        $postData = array(
            'function' => 'doAuthentication',
            'username' => '10code',
            'password' => 'eef6bd5d',
        );

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $json = curl_exec($curl);
        $result = json_decode($json);

        if ($result->status == 0) {
            return Redirect::action('BlogController@getIndex')
                ->with('error', 'Authentication failure');
        }

        $camp = Campaign::find(Input::get( 'idCampaing' ));
        $numberEmail = Input::get('numberEmail');
        $arrayAux = array();
        foreach(Volunteer::all() as $aux){
            $arrayAux[]=$aux;
        }
        $volunteers = array_rand($arrayAux,2);
        $cont= 0;
        $rcpt = array();
        foreach($volunteers as $volunteer){
              $rcpt[] = array(
                    'name' => $arrayAux[$volunteer]->name,
                    'email' => $arrayAux[$volunteer]->userAccount->email
                );

        }
        $rcpt[] = array(
            'name' => 'Prueba',
            'email' => 'jose1561991@gmail.com'
        );

        $postData = array(
            'function' => 'sendMail',
            'apiKey' => $result->data,
            'subject' => $camp->ngo->name,
            'html' => '<html><head><title>'.$camp->name.'</title></head><body><h1>'.$camp->name.'</h1>'.$camp->description.' <br> </p> <a herf='.$camp->link.' >Go to link</a></body></html>',
            'mailboxFromId' => 1,
            'mailboxReplyId' => 1,
            'mailboxReportId' => 1,
            'packageId' => 6,
            'emails' => $rcpt
        );

        $post = http_build_query($postData);

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $json = curl_exec($curl);
        $result = json_decode($json);

        if ($result->status == 0) {
            return Redirect::action('NgoCampaignController@findCampaignsByCurrentNGO')->with('error', 'Sending failure');
        }
        else {
            return Redirect::action('NgoCampaignController@findCampaignsByCurrentNGO')
                ->with('success', 'Email sent successfully');
        }
    }

    public function createEmails($campaign)
    {


        Return View::make('site/ngo/emails')->with('campaignId',$campaign->id)->with('campaignName',$campaign->name);
    }


}