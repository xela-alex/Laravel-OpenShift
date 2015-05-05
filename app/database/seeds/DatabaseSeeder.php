<?php

class DatabaseSeeder extends Seeder {

    public function run()
    {
        Eloquent::unguard();

        // Add calls to Seeders here
        $this->call('UsersTableSeeder');
        $this->call('RolesTableSeeder');
        $this->call('PermissionsTableSeeder');
        $this->call('NGOsTableSeeder');
        $this->call('CampaignsTableSeeder');
        $this->call('AdministratorsTableSeeder');
        $this->call('CompaniesTableSeeder');
        $this->call('ProjectTableSeeder');
        $this->call('VolunteersTableSeeder');
        $this->call('ApplicationsTableSeeder');
        $this->call('MessagesTableSeeder');
        $this->call('CategoriesTableSeeder');
        $this->call('VisitorsTableSeeder');
    }

}