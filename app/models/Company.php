<?php

class Company extends Eloquent {

	protected $table = 'company';
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

	public function sector()
	{
		return $this->sector;
	}

	public function description()
	{
		return $this->description;
	}

	public function phone()
	{
		return $this->phone;
	}

	public function logo()
	{
		return $this->logo;
	}

	public function active()
	{
		return $this->active;
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

	public function projects()
	{
		return $this->hasMany('Project');
	}

	public function messages()
	{
		return $this->hasMany('Message');
	}

	public function receivedMessages()
	{
		return $this->belongsToMany('Message', 'message_recipient', 'message_id', 'recipient_company_id');
	}


}