<?php

class Application extends Eloquent
{

    protected $table = 'application';
    public $timestamps = false;

    /**
     * Get the comment's content.
     *
     * @return string
     */
    public function moment()
    {
        return $this->moment;
    }

    public function comments()
    {
        return $this->comments;
    }

    public function result()
    {
        return $this->result;
    }

    /**
     * Get the comment's author.
     *
     * @return User
     */

    public function project()
    {
        return $this->belongsTo('Project', 'project_id');
    }

    public function volunteer()
    {
        return $this->belongsTo('Volunteer', 'volunteer_id');
    }

}