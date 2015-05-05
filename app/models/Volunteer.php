<?php

class Volunteer extends Eloquent
{

    protected $table = 'volunteer';
    public $timestamps = false;
    /**
     * Get the comment's content.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    public function banned()
    {
        return $this->banned;
    }

    public function surname()
    {
        return $this->surname;
    }

    public function address()
    {
        return $this->address;
    }

    public function city()
    {
        return $this->city;
    }

    public function zipCode()
    {
        return $this->zipCode;
    }

    public function country()
    {
        return $this->country;
    }

    public function biography()
    {
        return $this->biography;
    }

    /**
     * Get the comment's author.
     *
     * @return User
     */

    public function userAccount()
    {
        return $this->belongsTo('User', 'user_id');
    }

    public function cooperates()
    {
        return $this->belongsToMany('Project','project_volunteer','project_id','volunteer_id');
    }

    public function messages()
    {
        return $this->hasMany('Message');
    }

    public function receivedMessages()
    {
        return $this->belongsToMany('Message', 'message_recipient', 'message_id', 'recipient_volunteer_id');
    }
    public function applications()
    {
        return $this->hasMany('Application');
    }

}