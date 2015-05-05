<?php

class AdminSearchController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function searchVolunteers()
    {
        $data = array(
            'searchAction' => 'admin/search/findVolunteers',
        );

        Return View::make('admin/users/search')->with($data);
    }

    public function findVolunteersWithSimilarUsername()
    {
        $users = Volunteer::join('users', function($join)
            {
            $join->on('Volunteer.user_id', '=', 'users.id')
                ->where('users.username', 'like', '%'.Input::get('username').'%');
            })->get();

        $data = array(
            'users' => $users,
            'searchAction' => 'admin/search/findVolunteers',
            'searchType' => 'volunteers',
        );

        Input::flash();
        Return View::make('admin/users/search')->with($data);
    }

    public function searchCompanies()
    {
        $data = array(
            'searchAction' => 'admin/search/findCompanies',
        );

        Return View::make('admin/users/search')->with($data);
    }

    public function findCompaniesWithSimilarUsername()
    {
        $users = Company::join('users', function($join)
        {
            $join->on('Company.user_id', '=', 'users.id')
                ->where('users.username', 'like', '%'.Input::get('username').'%');
        })->get();

        $data = array(
            'users' => $users,
            'searchAction' => 'admin/search/findCompanies',
            'searchType' => 'companies',
        );

        Input::flash();
        Return View::make('admin/users/search')->with($data);
    }

    public function searchNGOs()
    {
        $data = array(
            'searchAction' => 'admin/search/findNGOs',
        );

        Return View::make('admin/users/search')->with($data);
    }

    public function findNGOsWithSimilarUsername()
    {
        $users = Ngo::join('users', function($join)
        {
            $join->on('Ngo.user_id', '=', 'users.id')
                ->where('users.username', 'like', '%'.Input::get('username').'%');
        })->get();

        $data = array(
            'users' => $users,
            'searchAction' => 'admin/search/findNGOs',
            'searchType' => 'NGOs',
        );

        Input::flash();
        Return View::make('admin/users/search')->with($data);
    }

}