<?php

class Visitor extends Eloquent {

	protected $table = 'visitor';
	public $timestamps = false;
    /**
	 * Get the comment's content.
	 *
	 * @return string
	 */
	public function ipAddress()
	{
		return $this->ipAddress;
	}


	/**
	 * Get the comment's author.
	 *
	 * @return User
	 */

	public function campaign()
	{
		return $this->belongsTo('Campaign', 'campaign_id');
	}


}