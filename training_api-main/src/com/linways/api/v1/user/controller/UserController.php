<?php

namespace com\linways\api\v1\userController\controller;

use com\linways\api\v1\BaseController;
use com\linways\core\dto\User;
use com\linways\core\request\LoginData;
use com\linways\core\request\PasswordUpdateData;
use com\linways\core\service\UserService;
use Linways\Slim\Utils\ResponseUtils;
use Slim\Http\Request;
use Slim\Http\Response;



class UserController extends BaseController
{

    // user SignUp function 
    protected function userSignup(Request $request, Response $response)
    {
        $body = $request->getParsedBody();
        $user = new User();
        $user->name = $body['name'];
        $user->phone = $body['phone'];
        $user->email = $body['email'];
        $user->password = $body['password'];

        try {

            $id = UserService::getInstance()->saveUser($user);
        } catch (\Exception $e) {

            return ResponseUtils::fault($response, $e);
        }
        return ResponseUtils::result($response, $id);
    }


    // user login function

    protected function userLogin(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $body = new LoginData();
        $body->email = $data['email'];
        $body->password = $data['password'];
        try {

            $id = UserService::getInstance()->userLogin($body);
        } catch (\Exception $e) {

            return ResponseUtils::fault($response, $e);
        }
        return ResponseUtils::result($response, $id);
    }


    //user update function
    protected function userUpdate(Request $request, Response $response)
    {
        $id = $request->getAttribute('id');
        $params = $request->getParsedBody();
        $user = new User();
        $user->id = $id;
        $user->name = $params['name'];
        $user->email = $params['email'];
        $user->phone = $params['phone'];
        $user->password = $params['password'];

        try {

            UserService::getInstance()->saveUser($user);
        } catch (\Exception $e) {

            return ResponseUtils::fault($response, $e);
        }
        return ResponseUtils::result($response);
    }


    //password update function
    protected function passwordUpdate(Request $request, Response $response)
    {
        $id = $request->getAttribute('id');
        $body = $request->getParsedBody();
        $passwordDto = new PasswordUpdateData();
        $passwordDto->userId = $id;
        $passwordDto->oldPassword = $body['oldPassword'];
        $passwordDto->newPassword = $body['newPassword'];

        try {

            UserService::getInstance()->updatePassword($passwordDto);
        } catch (\Exception $e) {

            return ResponseUtils::fault($response, $e);
        }
        return ResponseUtils::result($response);
    }



    //function to get user details 
    protected function getUserDetails(Request $request, Response $response)
    {

        $id = $request->getAttribute('id');
        try {

            $result = UserService::getInstance()->userdetails($id);
        } catch (\Exception $e) {

            return ResponseUtils::fault($response, $e);
        }
        return ResponseUtils::result($response, $result);
    }


    //user delete function
    protected function userDelete(Request $request, Response $response)
    {

        $id = $request->getAttribute('id');
        try {

            UserService::getInstance()->deleteUser($id);
        } catch (\Exception $e) {

            return ResponseUtils::fault($response, $e);
        }
        return ResponseUtils::result($response);
    }
}
