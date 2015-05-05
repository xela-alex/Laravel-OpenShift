<?php

class CampaignsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('campaign')->delete();

        $campaigns = array(
            array(
                'name'      => 'Campaign 1',
                'description'      => 'Description campaign 1',
                'image'=> '/logos/imageNotFound.gif',
                'startDate'   => \Carbon\Carbon::createFromDate(2015,7,23)->toDateTimeString(),
                'finishDate' => \Carbon\Carbon::createFromDate(2015,8,23)->toDateTimeString(),
                'visits' => 0,
                'link' => 'http://www.blahblahblah.com',
                'maxVisits' => 100,
                'expirationDate' => \Carbon\Carbon::createFromDate(2015,7,30)->toDateTimeString(),
                'ngo_id' => Ngo::where('user_id','=',User::where('username','=','ngo1')->first()->id)->first()->id,
            ),
            array(
                'name'      => 'Campaign 2',
                'description'      => 'Description campaign 2',
                'image'=> '/logos/imageNotFound.gif',
                'startDate'   => \Carbon\Carbon::createFromDate(2015,8,23)->toDateTimeString(),
                'finishDate' => \Carbon\Carbon::createFromDate(2015,9,23)->toDateTimeString(),
                'visits' => 5,
                'link' => 'http://www.blahblahblah2.com',
                'maxVisits' => 150,
                'expirationDate' => \Carbon\Carbon::createFromDate(2015,8,30)->toDateTimeString(),
                'ngo_id' => Ngo::where('user_id','=',User::where('username','=','ngo2')->first()->id)->first()->id,
            ),
        );

        DB::table('campaign')->insert( $campaigns );
    }

}
