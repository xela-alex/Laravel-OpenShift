<?php

class Message extends Eloquent
{

    protected $table = 'message';
    public $timestamps = false;

    /**
     * Get the comment's content.
     *
     * @return string
     */
    public function subject()
    {
        return $this->subject;
    }

    public function textBox()
    {
        return $this->textBox;
    }

    public function _from()
    {
        return $this->from;
    }
    public function to()
    {
        return $this->to;
    }
    public function date()
    {
        return $this->date;
    }

    /**
     * Get the comment's author.
     *
     * @return User
     */

    public function sender_administrator()
    {
        return $this->belongsTo('Administrator', 'administrator_id');
    }

    public function sender_ngo()
    {
        return $this->belongsTo('Ngo', 'ngo_id');
    }

    public function sender_volunteer()
    {
        return $this->belongsTo('Volunteer', 'volunteer_id');
    }

    public function sender_company()
    {
        return $this->belongsTo('Company', 'company_id');
    }

    public function recipients_ngo()
    {
        return $this->belongsToMany('Ngo', 'message_recipient', 'message_id', 'recipient_ngo_id');
    }

    public function recipients_company()
    {
        return $this->belongsToMany('Ngo', 'message_recipient', 'message_id', 'recipient_company_id');
    }

    public function recipients_volunteer()
    {
        return $this->belongsToMany('Ngo', 'message_recipient', 'message_id', 'recipient_volunteer_id');
    }

    public function recipients_administrator()
    {
        return $this->belongsToMany('Ngo', 'message_recipient', 'message_id', 'recipient_administrator_id');
    }


}