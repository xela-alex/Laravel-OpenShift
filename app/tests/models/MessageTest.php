<?php

use Illuminate\Database\Query\Builder;

class MessageTest extends TestCase {

    public function setUp(){
        parent::setUp();
        $this->message = Message::find(1);
        $this->administrator = Administrator::find($this->message->administrator_id);
    }

    public function testSubject()
    {
        $this->assertEquals( $this->message->subject, 'Subject 1' );
    }

    public function testSubjectIsAString()
    {
        $this->assertInternalType( 'string', $this->message->subject);
    }

    public function testTextBox()
    {
        $this->assertEquals( $this->message->textBox, 'This is a message 1' );
    }

    public function testTextBoxIsAString()
    {
        $this->assertInternalType( 'string', $this->message->textBox);
    }

    public function testDate()
    {
        $this->assertEquals( date('Y-m-d', strtotime($this->message->date)), date('Y-m-d', strtotime(\Carbon\Carbon::createFromDate(2015,8,23))));
    }

    public function testMessageDateIsADate()
    {
        $this->assertInternalType( 'string', date('Y-m-d', strtotime($this->message->startDate)));
    }

    public function testFrom()
    {
        $this->assertEquals( $this->message->from, 'Administrator 1');
    }

    public function testFromIsAString()
    {
        $this->assertInternalType( 'string', $this->message->from);
    }

    public function testTo()
    {
        $this->assertEquals( $this->message->to, 'Broadcast volunteers');
    }

    public function testToIsAString()
    {
        $this->assertInternalType( 'string', $this->message->to);
    }

    public function testMessageWasSentByAdmin()
    {
        $this->assertGreaterThan( $this->message->administrator_id, 0);
        $this->assertNull( $this->message->company_id);
        $this->assertNull( $this->message->volunteer_id);
        $this->assertNull( $this->message->ngo_id);
    }

}
