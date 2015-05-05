<?php

class CompanyControllerTest extends BaseControllerTestCase {

    // Registration of new company

    public function testRegisterAsCompanyResponse()
    {
        $this->flushSession();

        $this->requestAction('GET', 'CompanyController@getCreate');
        $this->assertResponseOk();
        $this->assertViewHas('backUrl');
    }

    public function testRegisterAsCompanyRequiredParameter()
    {
        $this->flushSession();

        $this->requestAction('GET', 'CompanyController@getCreate');
        $this->assertResponseOk();

        // Register as company3
        $companyData = array(
            //'username'                      => 'company3',
            'email'                         => 'company3@gmail.com',
            'password'                      => 'company3',
            'password_confirmation'         => 'company3',
            'name'                          => 'Company 3',
            'sector'                        => 'Sector 3',
            'description'                   => 'Description company 3',
            'phone'                         => '6543210123',
            'logo'                          => new Symfony\Component\HttpFoundation\File\UploadedFile('C:\ds-firebird-logo-500.png', 'ds-firebird-logo-500.png'),
        );

        $this->withInput( $companyData )->requestAction('POST', 'CompanyController@postIndex');
        $this->assertSessionHasErrors('username');
    }

    public function testRegisterAsCompanyNotEnoughLength()
    {
        $this->flushSession();

        $this->requestAction('GET', 'CompanyController@getCreate');
        $this->assertResponseOk();

        // Register as company3
        $companyData = array(
            'username'                      => 'ab',
            'email'                         => 'company3@gmail.com',
            'password'                      => 'company3',
            'password_confirmation'         => 'company3',
            'name'                          => 'Company 3',
            'sector'                        => 'Sector 3',
            'description'                   => 'Description company 3',
            'phone'                         => '6543210123',
            'logo'                          => new Symfony\Component\HttpFoundation\File\UploadedFile('C:\ds-firebird-logo-500.png', 'ds-firebird-logo-500.png'),
        );

        $this->withInput( $companyData )->requestAction('POST', 'CompanyController@postIndex');
        $this->assertSessionHasErrors('username');
    }

    public function testRegisterAsCompanyTooMuchLength()
    {
        $this->flushSession();

        $this->requestAction('GET', 'CompanyController@getCreate');
        $this->assertResponseOk();

        // Register as company3
        $companyData = array(
            'username'                      => 'abcdefghijklmnopqrstuvwxyz1234567890',
            'email'                         => 'company3@gmail.com',
            'password'                      => 'company3',
            'password_confirmation'         => 'company3',
            'name'                          => 'Company 3',
            'sector'                        => 'Sector 3',
            'description'                   => 'Description company 3',
            'phone'                         => '6543210123',
            'logo'                          => new Symfony\Component\HttpFoundation\File\UploadedFile('C:\ds-firebird-logo-500.png', 'ds-firebird-logo-500.png'),
        );

        $this->withInput( $companyData )->requestAction('POST', 'CompanyController@postIndex');
        $this->assertSessionHasErrors('username');
    }

    public function testRegisterAsCompanyUsernameAlreadyTaken()
    {
        $this->flushSession();

        $this->requestAction('GET', 'CompanyController@getCreate');
        $this->assertResponseOk();

        // Register as company3
        $companyData = array(
            'username'                      => 'company1',
            'email'                         => 'company3@gmail.com',
            'password'                      => 'company3',
            'password_confirmation'         => 'company3',
            'name'                          => 'Company 3',
            'sector'                        => 'Sector 3',
            'description'                   => 'Description company 3',
            'phone'                         => '6543210123',
            'logo'                          => new Symfony\Component\HttpFoundation\File\UploadedFile('C:\ds-firebird-logo-500.png', 'ds-firebird-logo-500.png'),
        );

        $this->withInput( $companyData )->requestAction('POST', 'CompanyController@postIndex');
        $this->assertSessionHasErrors('username');
    }

    public function testRegisterAsCompanyEmailFieldIsNotAEmail()
    {
        $this->flushSession();

        $this->requestAction('GET', 'CompanyController@getCreate');
        $this->assertResponseOk();

        // Register as company3
        $companyData = array(
            'username'                      => 'company3',
            'email'                         => 'email',
            'password'                      => 'company3',
            'password_confirmation'         => 'company3',
            'name'                          => 'Company 3',
            'sector'                        => 'Sector 3',
            'description'                   => 'Description company 3',
            'phone'                         => '6543210123',
            'logo'                          => new Symfony\Component\HttpFoundation\File\UploadedFile('C:\ds-firebird-logo-500.png', 'ds-firebird-logo-500.png'),
        );

        $this->withInput( $companyData )->requestAction('POST', 'CompanyController@postIndex');
        $this->assertSessionHasErrors('email');
    }

    public function testRegisterAsCompanyPhoneFieldDoesNotMatchPattern()
    {
        $this->flushSession();

        $this->requestAction('GET', 'CompanyController@getCreate');
        $this->assertResponseOk();

        // Register as company3
        $companyData = array(
            'username'                      => 'company1',
            'email'                         => 'company3@gmail.com',
            'password'                      => 'company3',
            'password_confirmation'         => 'company3',
            'name'                          => 'Company 3',
            'sector'                        => 'Sector 3',
            'description'                   => 'Description company 3',
            'phone'                         => 'abcd',
            'logo'                          => new Symfony\Component\HttpFoundation\File\UploadedFile('C:\ds-firebird-logo-500.png', 'ds-firebird-logo-500.png'),
        );

        $this->withInput( $companyData )->requestAction('POST', 'CompanyController@postIndex');
        $this->assertSessionHasErrors('phone');
    }

    public function testRegisterAsCompanyLogoFieldIsNotAnImage()
    {
        $this->flushSession();

        $this->requestAction('GET', 'CompanyController@getCreate');
        $this->assertResponseOk();

        // Register as company3
        $companyData = array(
            'username'                      => 'company1',
            'email'                         => 'company3@gmail.com',
            'password'                      => 'company3',
            'password_confirmation'         => 'company3',
            'name'                          => 'Company 3',
            'sector'                        => 'Sector 3',
            'description'                   => 'Description company 3',
            'phone'                         => '6543210123',
            'logo'                          => 'abcd',
        );

        $this->withInput( $companyData )->requestAction('POST', 'CompanyController@postIndex');
        $this->assertSessionHasErrors('logo');
    }

    public function testRegisterAsCompanyConfirmPasswordFieldDoesNotMatchPasswordField()
    {
        $this->flushSession();

        $this->requestAction('GET', 'CompanyController@getCreate');
        $this->assertResponseOk();

        // Register as company3
        $companyData = array(
            'username'                      => 'company3',
            'email'                         => 'company3@gmail.com',
            'password'                      => 'company3',
            'password_confirmation'         => 'company4',
            'name'                          => 'Company 3',
            'sector'                        => 'Sector 3',
            'description'                   => 'Description company 3',
            'phone'                         => '6543210123',
            'logo'                          => new Symfony\Component\HttpFoundation\File\UploadedFile('C:\ds-firebird-logo-500.png', 'ds-firebird-logo-500.png'),
        );

        $this->withInput( $companyData )->requestAction('POST', 'CompanyController@postIndex');
    }

}
