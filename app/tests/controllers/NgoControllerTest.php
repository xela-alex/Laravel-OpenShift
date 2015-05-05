<?php

class NgoControllerTest extends BaseControllerTestCase {

    // Registration of new company

    public function testRegisterAsNgoResponse()
    {
        $this->flushSession();

        $this->requestAction('GET', 'NgoController@getCreate');
        $this->assertResponseOk();
        $this->assertViewHas('backUrl');
    }

    public function testRegisterAsNgoRequiredParameter()
    {
        $this->flushSession();

        $this->requestAction('GET', 'NgoController@getCreate');
        $this->assertResponseOk();

        // Register as company3
        $companyData = array(
            //'username'                      => 'ngo3',
            'email'                         => 'ngo3@gmail.com',
            'password'                      => 'ngo3',
            'password_confirmation'         => 'ngo3',
            'name'                          => 'ngo  3',
            'holderName'                    => 'NGO 3',
            'brandName'                     => 'Visa',
            'number'                        => '4532820703718551',
            'expirationMonth'               => 10,
            'expirationYear'                => 2015,
            'cvv'                           => 507,
            'description'                   => 'Description ngo 3',
            'phone'                         => '6789610123',
        );

        $this->withInput( $companyData )->requestAction('POST', 'NgoController@postIndex');
        $this->assertSessionHasErrors('username');
    }

    public function testRegisterAsNgoNotEnoughLength()
    {
        $this->flushSession();

        $this->requestAction('GET', 'NgoController@getCreate');
        $this->assertResponseOk();

        // Register as company3
        $companyData = array(
            'username'                      => 'ab',
            'email'                         => 'ngo3@gmail.com',
            'password'                      => 'ngo3',
            'password_confirmation'         => 'ngo3',
            'name'                          => 'ngo  3',
            'holderName'                    => 'NGO 3',
            'brandName'                     => 'Visa',
            'number'                        => '4532820703718551',
            'expirationMonth'               => 10,
            'expirationYear'                => 2015,
            'cvv'                           => 507,
            'description'                   => 'Description ngo 3',
            'phone'                         => '6789610123',
        );

        $this->withInput( $companyData )->requestAction('POST', 'NgoController@postIndex');
        $this->assertSessionHasErrors('username');
    }

    public function testRegisterAsNgoTooMuchLength()
    {
        $this->flushSession();

        $this->requestAction('GET', 'NgoController@getCreate');
        $this->assertResponseOk();

        // Register as company3
        $companyData = array(
            'username'                      => 'abcdefghijklmnopqrstuvwxyz1234567890',
            'email'                         => 'ngo3@gmail.com',
            'password'                      => 'ngo3',
            'password_confirmation'         => 'ngo3',
            'name'                          => 'ngo  3',
            'holderName'                    => 'NGO 3',
            'brandName'                     => 'Visa',
            'number'                        => '4532820703718551',
            'expirationMonth'               => 10,
            'expirationYear'                => 2015,
            'cvv'                           => 507,
            'description'                   => 'Description ngo 3',
            'phone'                         => '6789610123',
        );

        $this->withInput( $companyData )->requestAction('POST', 'NgoController@postIndex');
        $this->assertSessionHasErrors('username');
    }

    public function testRegisterAsCompanyUsernameAlreadyTaken()
    {
        $this->flushSession();

        $this->requestAction('GET', 'NgoController@getCreate');
        $this->assertResponseOk();

        $companyData = array(
            'username'                      => 'ngo1',
            'email'                         => 'ngo1@gmail.com',
            'password'                      => 'ngo1',
            'password_confirmation'         => 'ngo1',
            'name'                          => 'ngo  1',
            'holderName'                    => 'NGO 1',
            'brandName'                     => 'Visa',
            'number'                        => '4532820703718551',
            'expirationMonth'               => 10,
            'expirationYear'                => 2015,
            'cvv'                           => 507,
            'description'                   => 'Description ngo 1',
            'phone'                         => '6789610123',
        );

        $this->withInput( $companyData )->requestAction('POST', 'NgoController@postIndex');
        $this->assertSessionHasErrors('username');
    }

    public function testRegisterAsNgoEmailFieldIsNotAEmail()
    {
        $this->flushSession();

        $this->requestAction('GET', 'NgoController@getCreate');
        $this->assertResponseOk();

        // Register as company3
        $companyData = array(
            'username'                      => 'ngo3',
            'email'                         => 'emailBad',
            'password'                      => 'ngo3',
            'password_confirmation'         => 'ngo3',
            'name'                          => 'ngo  3',
            'holderName'                    => 'NGO 3',
            'brandName'                     => 'Visa',
            'number'                        => '4532820703718551',
            'expirationMonth'               => 10,
            'expirationYear'                => 2015,
            'cvv'                           => 507,
            'description'                   => 'Description ngo 3',
            'phone'                         => '6789610123',
        );

        $this->withInput( $companyData )->requestAction('POST', 'NgoController@postIndex');
        $this->assertSessionHasErrors('email');
    }

    public function testRegisterAsNgoPhoneFieldDoesNotMatchPattern()
    {
        $this->flushSession();

        $this->requestAction('GET', 'NgoController@getCreate');
        $this->assertResponseOk();

        // Register as company3
        $companyData = array(
            'username'                      => 'company1',
            'email'                         => 'ngo3@gmail.com',
            'password'                      => 'ngo3',
            'password_confirmation'         => 'ngo3',
            'name'                          => 'ngo  3',
            'holderName'                    => 'NGO 3',
            'brandName'                     => 'Visa',
            'number'                        => '4532820703718551',
            'expirationMonth'               => 10,
            'expirationYear'                => 2015,
            'cvv'                           => 507,
            'description'                   => 'Description ngo 3',
            'phone'                         => 'badPhone',
        );

        $this->withInput( $companyData )->requestAction('POST', 'NgoController@postIndex');
        $this->assertSessionHasErrors('phone');
    }

    public function testRegisterAsNgoLogoFieldIsNotAnImage()
    {
        $this->flushSession();

        $this->requestAction('GET', 'NgoController@getCreate');
        $this->assertResponseOk();

        // Register as company3
        $companyData = array(
            'username'                      => 'ngo3',
            'email'                         => 'ngo3@gmail.com',
            'password'                      => 'ngo3',
            'password_confirmation'         => 'ngo3',
            'name'                          => 'ngo  3',
            'holderName'                    => 'NGO 3',
            'brandName'                     => 'Visa',
            'number'                        => '4532820703718551',
            'expirationMonth'               => 10,
            'expirationYear'                => 2015,
            'cvv'                           => 507,
            'description'                   => 'Description ngo 3',
            'phone'                         => '6789610123',
            'logo'                          => 'abcd',
        );

        $this->withInput( $companyData )->requestAction('POST', 'NgoController@postIndex');
        $this->assertSessionHasErrors('logo');
    }
}
