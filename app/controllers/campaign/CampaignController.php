<?php

class CampaignController extends BaseController
{
    public function __construct(Campaign $campaign, Visitor $visitor)
    {
        parent::__construct();
        $this->campaign = $campaign;
        $this->visitor = $visitor;
    }

    public function findAllActiveCampaigns()
    {
        $campaigns = Campaign::where('expirationDate', '>', Carbon::now())->paginate(4);

        $data = array(
            'campaigns' => $campaigns,
        );

        Return View::make('site/campaign/list')->with($data);
    }

    public function campaignDetails($id)
    {
        $campaign = Campaign::where('id','=',$id)->first();
        $ngo = Ngo::where('id','=',$campaign->ngo_id)->first();

        $data = array(
            'campaign' => $campaign,
            'ngo' => $ngo,
        );

        Return View::make('site/campaign/details', $data);
    }

    public function payToClick($id) {
        $userIP = Request::ip();
        $user = Auth::user();
        $this->campaign = Campaign::find($id);
        $ngo = Ngo::find($this->campaign->ngo_id);

        if( $user->actor() != $this->campaign->ngo && $this->campaign->visits <= $this->campaign->maxVisits &&
            $this->campaign->expirationDate >= new DateTime('now') && !Visitor::where('ipAddress', '=', $userIP)->where('campaign_id', '=', $this->campaign->id)->first()) {
                if( count(Campaign::where('ngo_id', '=', $this->campaign->ngo->id)->get()) <= 2 ) {
                    Return Redirect::to($this->campaign->link);
                }
                if( count(Campaign::where('ngo_id', '=', $this->campaign->ngo->id)->get()) > 2 ) {
                    if( $this->campaign->visits <= 200 ) {
                        $ngo->update(array('credits' => $ngo->credits - 6));
                    }
                    if( $this->campaign->visits > 200 && $this->campaign->visits <= 1000 ) {
                        $ngo->update(array('credits' => $ngo->credits - 9));
                    }
                    if( $this->campaign->visits > 1000 ) {
                        $ngo->update(array('credits' => $ngo->credits - 12));
                    }
                }
        }

        if( !Visitor::where('ipAddress', '=', $userIP)->first() ) {
            $this->visitor->ipAddress = $userIP;
            $this->visitor->campaign_id = $this->campaign->id;
            $this->visitor->save();
        }

        $this->campaign->visits = $this->campaign->visits + 1;
        $this->campaign->save();
        Return Redirect::to($this->campaign->link);
    }

}