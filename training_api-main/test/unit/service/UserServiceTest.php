<?php

namespace test\service;

use com\linways\base\test\BaseTestCase;
use com\linways\core\dto\User;
use com\linways\core\dto\Users;
use com\linways\core\request\LoginData;
use com\linways\core\request\PasswordUpdateData;
use com\linways\core\service\UserService;

class UserServiceTest extends BaseTestCase
{

    protected function setUp()
    {
        $testDBConfPath = __DIR__ . '/../../db_conf/ams_db_conf.php';
        putenv("TEST_DB_CONFIG=$testDBConfPath");
        putenv("DB_PROFESIONAL_CONFIG=$testDBConfPath");
        putenv("DB_PROFESSIONAL_CONFIG=$testDBConfPath");
        // $this->clearDBTable('users');
    }

    public function createUser()
    {
        $user = new User();
        $user->name = 'Joe Doe';
        $user->email = 'testuser@test.com';
        $user->phone = '8585858585';
        $user->password = 'User1@1022';
    
        return $user;
    }

    public function login()
    {
        $user = new LoginData();
        $user->email = 'testuser@test.com';
        $user->password = 'User1@1022';
        return $user;
    }

    public function updateUser()
    {
        $user = new User();
        $user->id = 22;
        $user->name = 'Joe Doe 123';
        $user->email = 'testuser@test.com';
        $user->phone = '8585858585';
        $user->password = 'User1@1022';
        return $user;
    }

    public function updatePassword()
    {
        $passwordData = new PasswordUpdateData();
        $passwordData->userId=22;
        $passwordData->oldPassword ="User1@2023";
        $passwordData->newPassword="User1@2023";
        return $passwordData;
    }



    public function testCreateUser()
    {
        $user = $this->createUser();
        $result = UserService::getInstance()->createUser($user);
        $this->assertIsInt($result);
    }

    public function testLogin()
    {
        $user = $this->login();
        $result = UserService::getInstance()->userLogin($user);
        $this->assertIsObject($result);
    }



    public function testUpdate()
    {
        $user = $this->updateUser();
        $result = UserService::getInstance()->updateUser($user);
        $this->assertDatabaseHas("users", [
            "id" => "22", "name" => "Joe Doe 123", "email" => "testuser@test.com",
            "phone" => "8585858585"
        ]);
    }



    public function testPasswordUpdate()
    {
        $passwordData = $this->updatePassword();
        UserService::getInstance()->updatePassword($passwordData);
        $this->assertDatabaseHas("users",["password"=>"MD5(User1@2023)"]);
        
    }



    public function testUserDetails()
    {
        $result = UserService::getInstance()->userDetails(22);
        $this->assertIsObject($result);
    }



    public function testDeleteUser()
    {
        $this->assertDatabaseHas('users',["id"=>"22"]);
        $result = UserService::getInstance()->deleteUser(22);

        $this->assertDatabaseHasNot('users',["id"=>"22"]);
    }
}
