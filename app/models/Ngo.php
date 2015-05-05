<?php

class Ngo extends Eloquent {

	protected $table = 'ngo';
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

	public function holderName()
	{
		return $this->holderName;
	}

	public function brandName()
	{
		return $this->brandName;
	}

	public function number()
	{
		return $this->number;
	}

	public function expirationMonth()
	{
		return $this->expirationMonth;
	}

	public function expirationYear()
	{
		return $this->expirationYear;
	}

	public function cvv()
	{
		return $this->cvv;
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

	public function campaigns()
	{
		return $this->hasMany('Campaign');
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
		return $this->belongsToMany('Message', 'message_recipient', 'message_id', 'recipient_ngo_id');
	}


}