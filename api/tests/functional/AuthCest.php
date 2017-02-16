<?php
namespace api\tests;
use api\tests\FunctionalTester;
use common\fixtures\User as UserFixture;

class AuthCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        $I->wantTo('Create User via api');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('X-Device-identifier', 'abcde123');
        $I->sendPOST('auth/register',[
          'User' =>[
            'username'=>'asl'
          ]
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
    }
}
