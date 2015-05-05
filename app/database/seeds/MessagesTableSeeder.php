<?php

class MessagesTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('message')->delete();
        DB::table('message_recipient')->delete();

        $messages = array(
            array(
                'subject' => 'Subject 1',
                'textBox' => 'This is a message 1',
                'from' => 'Administrator 1',
                'to' => 'Broadcast volunteers',
                'date' =>\Carbon\Carbon::createFromDate(2015,8,23)->toDateTimeString(),
                'administrator_id' => Administrator::where('user_id', '=', User::where('username', '=', 'administrator1')->first()->id)->first()->id,
            ),
            array(
                'subject' => 'Subject 2',
                'textBox' => 'This is a message 2',
                'from' => 'Administrator 2',
                'to' => 'Broadcast ngo\'s',
                'date' =>\Carbon\Carbon::createFromDate(2015,9,15)->toDateTimeString(),
                'administrator_id' => Administrator::where('user_id', '=', User::where('username', '=', 'administrator2')->first()->id)->first()->id,
            ),
            array(
                'subject' => 'Subject 3',
                'textBox' => 'This is a message 3',
                'from' => 'Administrator 1',
                'to' => 'Broadcast companies',
                'date' =>\Carbon\Carbon::createFromDate(2015,11,10)->toDateTimeString(),
                'administrator_id' => Administrator::where('user_id', '=', User::where('username', '=', 'administrator1')->first()->id)->first()->id,
            ),
        );

        DB::table('message')->insert($messages);


        $messages_recipientsVolunteer = array(
            # First message
            array(
                'message_id' => Message::where('subject', '=', 'Subject 1')->first()->id,
                'recipient_volunteer_id' => Volunteer::where('user_id', '=', User::where('username', '=', 'volunteer1')->first()->id)->first()->id,
                'read'=>true
            ),
            array(
                'message_id' => Message::where('subject', '=', 'Subject 1')->first()->id,
                'recipient_volunteer_id' => Volunteer::where('user_id', '=', User::where('username', '=', 'volunteer2')->first()->id)->first()->id,
                'read'=>true
            )
        );
        $messages_recipientsNgo = array(
            # Second message
            array(
                'message_id' => Message::where('subject', '=', 'Subject 2')->first()->id,
                'recipient_ngo_id' => Ngo::where('user_id', '=', User::where('username', '=', 'ngo1')->first()->id)->first()->id,
                'read'=>true
            ),
            array(
                'message_id' => Message::where('subject', '=', 'Subject 2')->first()->id,
                'recipient_ngo_id' => Ngo::where('user_id', '=', User::where('username', '=', 'ngo2')->first()->id)->first()->id,
                'read'=>true
            )
        );

        $messages_recipientsCompany = array(

            # Third message
            array(
                'message_id' => Message::where('subject', '=', 'Subject 3')->first()->id,
                'recipient_company_id' => Company::where('user_id', '=', User::where('username', '=', 'company1')->first()->id)->first()->id,
                'read'=>true
            ),

            array(
                'message_id' => Message::where('subject', '=', 'Subject 3')->first()->id,
                'recipient_company_id' => Company::where('user_id', '=', User::where('username', '=', 'company2')->first()->id)->first()->id,
                'read'=>true
            )
        );



        DB::table('message_recipient')->insert($messages_recipientsCompany);
        DB::table('message_recipient')->insert($messages_recipientsNgo);
        DB::table('message_recipient')->insert($messages_recipientsVolunteer);
    }

}
