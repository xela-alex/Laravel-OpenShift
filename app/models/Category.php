<?php

class Category extends Eloquent {

	protected $table = 'category';
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

	public function project()
	{
		return $this->belongsToMany('Project', 'project_category');
	}


}