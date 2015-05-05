<?php

class Campaign extends Eloquent {

	protected $table = 'campaign';
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

    public function description()
    {
        return $this->description;
    }

    public function image()
    {
        return $this->image;
    }

	public function address()
	{
		return $this->address;
	}

	public function startDate()
	{
		return $this->startDate;
	}

	public function finishDate()
	{
		return $this->finishDate;
	}

	public function visits()
	{
		return $this->visits;
	}

	public function link()
	{
		return $this->link;
	}

	public function maxVisits()
	{
		return $this->maxVisits;
	}

	public function promotionDuration()
	{
		return $this->promotionDuration;
	}

	/**
	 * Get the comment's author.
	 *
	 * @return User
	 */
	public function ngo()
	{
		return $this->belongsTo('Ngo', 'ngo_id');
	}

	public function visitors()
	{
		return $this->hasMany('Visitor');
	}


}