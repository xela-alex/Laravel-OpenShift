<?php

class VisitorsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('visitor')->delete();

        $visitors = array(
            array(
                'ipAddress'      => '1.2.3.4',
                'campaign_id'    => Campaign::where('id','=',1)->first()->id,
            ),
            array(
                'ipAddress'      => '5.6.7.8',
                'campaign_id'    => Campaign::where('id','=',2)->first()->id,
            ),
        );

        DB::table('visitor')->insert( $visitors );
    }

}
