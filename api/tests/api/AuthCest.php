<?php
namespace api\tests;
use api\tests\ApiTester;
use common\fixtures\User as UserFixture;

class AuthCest
{
    public function _before(ApiTester $I)
    {
        $I->haveFixtures([
          'user' => [
            'class' => UserFixture::className(),
            'dataFile' => codecept_data_dir() . 'login_data.php'
          ]
        ]);
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function createUser(ApiTester $I)
    {
        $I->wantTo('create a user via API');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('X-Device-identifier', 'abcde1234');
        $I->sendPOST('/register', ['name' => 'alvian', 'email' => 'alvian@akupeduli.org', 'password' => 'alvian1']);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseContains('{"result":"ok"}');
        $I->seeResponseContains(
          '{
              "name": "Success",
              "message": "Registration as user alvian success.",
              "code": 10,
              "status": 200,
              "data": {
                "username": "alvian",
                "email": "alvian@akupeduli.org"
              }
            }'
        );
    }
}
