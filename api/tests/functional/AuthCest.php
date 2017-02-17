<?php
namespace api\tests;

use api\tests\FunctionalTester;

/**
 * Class AuthCest
 * @package api\tests
 */
class AuthCest
{

    /**
     * @param \api\tests\FunctionalTester $I
     */
    public function _before(FunctionalTester $I)
    {
    }

    /**
     * @param \api\tests\FunctionalTester $I
     */
    public function _after(FunctionalTester $I)
    {
    }



//==========================
//Scenario test For Sign up
//==========================

    /**
     * User sign up with empty fields
     *
     * @param \api\tests\FunctionalTester $I
     */
    public function signupWithEmptyFields(FunctionalTester $I)
    {

    }

    /**
     * Sign up with not standard email
     *
     * @param \api\tests\FunctionalTester $I
     */
    public function signupWithWrongEmail(FunctionalTester $I)
    {
    }

    /**
     * User already registered in system
     *
     * @param \api\tests\FunctionalTester $I
     */
    public function signupAlreadyRegistered(FunctionalTester $I)
    {

    }

    /**
     * user Sign up success
     *
     * @param \api\tests\FunctionalTester $I
     */
    public function signupSuccessfully(FunctionalTester $I)
    {
    }


//=========================
//Scenario test For login
//=========================

    /**
     * send blank username into login
     *
     * @param \api\tests\FunctionalTester $I
     */
    public function blankLogin(FunctionalTester $I)
    {
        $I->wantTo('Check blank username Login scenario');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('X-Device-identifier', 'abcde123');
        $I->sendPOST('auth/login', ['User[username]' => '']);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::UNAUTHORIZED);  //401
    }

    /**
     * check login with wrong password
     *
     * @param \api\tests\FunctionalTester $I
     */
    public function wrongPassword(FunctionalTester $I)
    {

    }

    /**
     * check login success
     *
     * @param \api\tests\FunctionalTester $I
     */
    public function SuccessLogin(FunctionalTester $I)
    {

    }

//===================================
//Scenario test For Forgot Password
//===================================

    /**
     * send blank username into forgot Form
     *
     * @param \api\tests\FunctionalTester $I
     */
    public function blankUsername(FunctionalTester $I)
    {
        $I->wantTo('Check blank username scenario');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('X-Device-identifier', 'abcde123');
        $I->sendPOST('auth/forgot-password', [
          'User' => [
            'username' => ''
          ]
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::UNAUTHORIZED);  //401
    }

    /**
     * send GET method to forgot password
     *
     * @param \api\tests\FunctionalTester $I
     */
    public function getForgotPassword(FunctionalTester $I)
    {
        $I->wantTo('Send GET Method to forgot password');
        $I->haveHttpHeader('X-Device-identifier', 'abcde123');
        $I->sendGET('auth/forgot-password');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::METHOD_NOT_ALLOWED);  //405
    }

//==================================
//Scenario test For Reset Password
//==================================

    public function invalidToken(FunctionalTester $I)
    {
        $I->wantTo('Send GET Method to forgot password');
        $I->haveHttpHeader('X-Device-identifier', 'abcde123');
        $I->sendGET('auth/reset-password/-qFQxABjQHgsWOe6hToKXetTCqaaE1VT_1487297372');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST);  //405

    }

}
