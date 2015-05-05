<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/** ------------------------------------------
 *  Route model binding
 *  ------------------------------------------
 */
Route::model('user', 'User');
Route::model('comment', 'Comment');
Route::model('post', 'Post');
Route::model('role', 'Role');
Route::model('campaign', 'Campaign');
/** ------------------------------------------
 *  Route constraint patterns
 *  ------------------------------------------
 */
Route::pattern('comment', '[0-9]+');
Route::pattern('post', '[0-9]+');
Route::pattern('user', '[0-9]+');
Route::pattern('role', '[0-9]+');
Route::pattern('campaign', '[0-9]+');
Route::pattern('token', '[0-9a-z]+');

/** ------------------------------------------
 *  Admin Routes
 *  ------------------------------------------
 */
Route::group(array('prefix' => 'admin', 'before' => 'auth'), function () {
    # Search users
    Route::get('/search/searchVolunteers', 'AdminSearchController@searchVolunteers');
    Route::get('/search/findVolunteers', 'AdminSearchController@findVolunteersWithSimilarUsername');
    Route::get('/search/searchCompanies', 'AdminSearchController@searchCompanies');
    Route::get('/search/findCompanies', 'AdminSearchController@findCompaniesWithSimilarUsername');
    Route::get('/search/searchNGOs', 'AdminSearchController@searchNGOs');
    Route::get('/search/findNGOs', 'AdminSearchController@findNGOsWithSimilarUsername');

    # Send messages
    Route::get('/message/sendMessage/{id}', 'AdminMessageController@createMessage');
    Route::post('/message/sendMessage', 'AdminMessageController@sendMessage');
    Route::get('/message/broadcastMessage', 'AdminMessageController@createGlobalMessage');
    Route::post('/message/broadcastMessage', 'AdminMessageController@broadcastMessage');

    # Ban and unban users
    Route::get('/user/ban/{id}', 'AdminUsersController@banUser');
    Route::get('/user/unban/{id}', 'AdminUsersController@unbanUser');

    # Activate NGOs and companies accounts
    Route::get('/user/activateAccount/{id}', 'AdminUsersController@activateAccount');

    # Categories management
    Route::get('/category/list', 'AdminCategoryController@listCategories');
    Route::get('/category/delete/{id}', 'AdminCategoryController@delete');
    Route::post('/category/createAndEdit', 'AdminCategoryController@createAndEdit');

    # User Management
    Route::get('users/{user}/show', 'AdminUsersController@getShow');
    Route::get('users/{user}/edit', 'AdminUsersController@getEdit');
    Route::post('users/{user}/edit', 'AdminUsersController@postEdit');
    Route::get('users/{user}/delete', 'AdminUsersController@getDelete');
    Route::post('users/{user}/delete', 'AdminUsersController@postDelete');
    Route::controller('users', 'AdminUsersController');

    # User Role Management
    Route::get('roles/{role}/show', 'AdminRolesController@getShow');
    Route::get('roles/{role}/edit', 'AdminRolesController@getEdit');
    Route::post('roles/{role}/edit', 'AdminRolesController@postEdit');
    Route::get('roles/{role}/delete', 'AdminRolesController@getDelete');
    Route::post('roles/{role}/delete', 'AdminRolesController@postDelete');
    Route::controller('roles', 'AdminRolesController');

    # Admin Dashboard
    Route::controller('/', 'AdminDashboardController');
});
/** ------------------------------------------
 *  Volunteer Routes
 *  ------------------------------------------
 */

# list projects
Route::group(array('prefix' => 'volunteer', 'before' => 'auth'), function () {

    Route::get('/project/myVolunteerProjects', 'VolunteerProjectController@findMyVolunteersProjects');
    Route::get('/project/myCsrProjects', 'VolunteerProjectController@findMyCsrProjects');
    //apply project
    Route::get('/apply/project/{id}', 'VolunteerApplicationController@createApplication');
    Route::post('/apply/project/{id}', 'VolunteerApplicationController@saveApplication');
    Route::get('/application/Csr', 'VolunteerApplicationController@finMyApplicationsCsr');
    Route::get('/application/Volunteer', 'VolunteerApplicationController@finMyApplicationsVolunteer');
    Route::get('/application/cancel/{id}', 'VolunteerApplicationController@cancelApplication');
    Route::get('/application/view/{id}', 'VolunteerApplicationController@viewApplication');



# Send messages
    Route::get('/message/sendMessage/{id}', 'VolunteerMessageController@createMessage');
    Route::post('/message/sendMessage', 'VolunteerMessageController@sendMessage');
});

//NGO Functions
Route::group(array('prefix' => 'ngo', 'before' => 'auth'), function () {
    Route::get('/project/myVolunteersProjects', 'NgoProjectController@findMyVolunteersProjects');
    //Payment Credits
    Route::get('/credits/create', 'NgoCreditsController@getCreate');
    Route::post('/credits/create', 'NgoCreditsController@postCreate');
    Route::get('/executePayment', 'NgoCreditsController@getExecutePayment');

    //Email Marketing

    Route::post('/sendEmails', 'NgoCampaignController@sendEmails');
    Route::get('/createEmails/{campaign}', 'NgoCampaignController@createEmails');


    Route::get('/myCampaigns', 'NgoCampaignController@findCampaignsByCurrentNGO');
    Route::get('/campaign/create', 'NgoCampaignController@createCampaign');
    Route::post('/campaign/create', 'NgoCampaignController@saveCampaign');
    # Send messages
    Route::get('/message/sendMessage/{id}', 'NgoMessageController@createMessage');
    Route::post('/message/sendMessage', 'NgoMessageController@sendMessage');

    #application
    Route::get('/application/answered', 'NgoApplicationController@findOurAnsweredApplications');
    Route::get('/application/pending', 'NgoApplicationController@findOurPendingApplications');
    Route::get('/application/view/{id}', 'NgoApplicationController@viewApplication');
    Route::get('/application/answer/{id}/{answer}', 'NgoApplicationController@answer');



});

//Company Functions
Route::group(array('prefix' => 'company', 'before' => 'auth'), function () {
    # Send messages
    Route::get('/message/sendMessage/{id}', 'CompanyMessageController@createMessage');
    Route::post('/message/sendMessage', 'CompanyMessageController@sendMessage');

    //Csr projects controller
    Route::get('/project/myCsrProjects', 'CompanyProjectController@findMyCsrProjects');
    Route::get('/project/createCsrProject', 'CompanyProjectController@createCsrProject');
    Route::post('/project/createCsrProject', 'CompanyProjectController@saveCsrProject');
    Route::get('/project/editCsrProject/{id}', 'CompanyProjectController@editGetCsrProject');
    Route::post('/project/editCsrProject/{id}', 'CompanyProjectController@editSaveCsrProject');
    Route::get('/project/deleteCsrProject/{id}', 'CompanyProjectController@deleteCsrProject');

    #application
    Route::get('/application/answered', 'CompanyApplicationController@findOurAnsweredApplications');
    Route::get('/application/pending', 'CompanyApplicationController@findOurPendingApplications');
    Route::get('/application/view/{id}', 'CompanyApplicationController@viewApplication');
    Route::get('/application/answer/{id}/{answer}', 'CompanyApplicationController@answer');
});


/** ------------------------------------------
 *  Frontend Routes
 *  ------------------------------------------
 */

// User reset routes
Route::get('user/reset/{token}', 'UserController@getReset');
// User password reset
Route::post('user/reset/{token}', 'UserController@postReset');
//:: User Account Routes ::
Route::post('user/{user}/edit', 'UserController@postEdit');

//:: User Account Routes ::
Route::post('user/login', 'UserController@postLogin');

# User RESTful Routes (Login, Logout, Register, etc)
Route::controller('user', 'UserController');
Route::controller('userVolunteer', 'VolunteerController');
Route::controller('userNgo', 'NgoController');
Route::controller('userCompany', 'CompanyController');

//UnauthorizedController
Route::get('projects', 'ProjectController@getVolunteerProjects');
Route::get('projectsCsr', 'ProjectController@getCsrProjects');
Route::get('projectsFilter', 'ProjectController@findVolunteerProjects');
Route::get('projectsCsrFilter', 'ProjectController@findCsrProjects');
Route::get('project/view/{id}', 'ProjectController@viewVolunteerProject');
Route::get('projectCsr/view/{id}', 'ProjectController@viewCsrProject');

# list messages
Route::get('messages/inbox', 'MessageController@getInbox');
Route::get('messages/sent', 'MessageController@getSent');
Route::get('message/view/{id}', 'MessageController@view');

//Volunteering projects controller
Route::get('project/createVolunteerProject', 'NgoProjectController@createVolunteerProject');
Route::post('project/createVolunteerProject', 'NgoProjectController@saveVolunteerProject');
Route::get('project/editVolunteerProject/{id}', 'NgoProjectController@editGetVolunteerProject');
Route::post('project/editVolunteerProject/{id}', 'NgoProjectController@editSaveVolunteerProject');
Route::get('project/deleteVolunteerProject/{id}', 'NgoProjectController@deleteVolunteerProject');

// Campaigns controller
Route::get('campaign/findActive', 'CampaignController@findAllActiveCampaigns');
Route::get('campaign/details/{id}', 'CampaignController@campaignDetails');
Route::get('campaign/payToClick/{id}', 'CampaignController@payToClick');

//:: Application Routes ::

# Filter for detect language
Route::when('contact-us', 'detectLang');

# Contact Us Static Page
Route::get('contact-us', function () {
    // Return about us page
    return View::make('site/contact-us');
});

# Posts - Second to last set, match slug
Route::get('{postSlug}', 'BlogController@getView');
Route::post('{postSlug}', 'BlogController@postView');

# Index Page - Last route, no matches
#Route::get('/', array('after' => 'detectLang', 'uses' => 'BlogController@getIndex'));

Route::get('/', function()
{
	return View::make('hello');
});
