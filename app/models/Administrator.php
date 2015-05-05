<?php

class Administrator extends Eloquent {

	protected $table = 'administrator';
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

	/**
	 * Get the comment's author.
	 *
	 * @return User
	 */
	public function userAccount()
	{
		return $this->belongsTo('User', 'user_id');
	}


}