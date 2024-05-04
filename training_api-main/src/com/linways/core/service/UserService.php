<?php

namespace com\linways\core\service;


use com\linways\core\service\BaseService;
use com\linways\base\util\MakeSingletonTrait;
use com\linways\core\dto\User;
use com\linways\core\exception\GlobalException;
use com\linways\core\request\LoginData;
use com\linways\core\request\PasswordUpdateData;


class UserService extends BaseService
{
    use MakeSingletonTrait;

    /**
     * Save user data
     * @param  User $user
     * @return int id for createUser function and null for updateUser function
     */

    public function saveUser(User $user)
    {

        $user = $this->realEscapeObject($user);
        try {

            $this->validateSaveUser($user);

            if (!empty($user->id)) {
                $user->id = $this->updateUser($user);
            } else {
                $user->id = $this->createUser($user);
            }
            return $user->id;
        } catch (\Exception $e) {
            if (
                $e->getCode() != GlobalException::INVALID_PARAMETERS && $e->getCode() != GlobalException::EMPTY_PARAMETERS
                && $e->getCode() != GlobalException::DUPLICATE_ENTRY && $e->getCode() != GlobalException::USER_NOT_FOUND
            ) {
                throw new GlobalException(GlobalException::SOMETHING_WENT_WRONG, "Failed to save user 
                Please try again");
            } else if ($e->getCode() === GlobalException::DUPLICATE_ENTRY) {
                throw new GlobalException(
                    GlobalException::DUPLICATE_ENTRY,
                    "Cannot create user,Email id already exists!"
                );
            } else {
                throw new GlobalException($e->getCode(), $e->getMessage());
            }
        }
    }



    /**
     * create new user
     * @param  User $user
     * @return int $id
     */

    public function createUser(User $user)
    {
        $query = "INSERT INTO users (name, email,phone, password) 
            VALUES ('$user->name', '$user->email','$user->phone',MD5('$user->password'));";
        try {
            $id = $this->executeQueryForObject($query, True);
            return $id;
        } catch (\Exception $e) {
            throw new GlobalException($e->getCode(), $e->getMessage());
        }
    }



    /**
     * update user data
     * @param  User $user
     * @return null;
     */

    public function updateUser(User $user)
    {

        $query = "UPDATE users
        SET name= '$user->name', email= '$user->email',phone= '$user->phone'
        WHERE id='$user->id';";

        try {
            $this->executeQuery($query);
            return null;
        } catch (\Exception $e) {
            throw new GlobalException($e->getCode(), $e->getMessage());
        }
    }


    /**
     * update password
     * @param  PasswordUpdateData $passwordUpdateData
     * @return null
     */

    public function updatePassword(PasswordUpdateData $passwordUpdateData)
    {
        $query = "SELECT password FROM users WHERE id='$passwordUpdateData->userId'";
        $queryToUpdate = "UPDATE users SET password = MD5('$passwordUpdateData->newPassword')
         WHERE id='$passwordUpdateData->userId';";
        try {
            $passwordFromDb = $this->executeQueryForObject($query);

            if ($passwordFromDb->password == MD5($passwordUpdateData->oldPassword)) {
                if (
                    !preg_match(
                        "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/",
                        $passwordUpdateData->newPassword
                    )
                )
                    throw new GlobalException(GlobalException::INVALID_PARAMETERS, "At least 8 characters,
                            Contains at least one uppercase letter,
                            Contains at least one lowercase letter,
                            Contains at least one number,
                            Contains at least one special character");
                $this->executeQuery($queryToUpdate);
                return null;
            }
            throw new GlobalException(GlobalException::INVALID_PARAMETERS, "Old password is incorrect");
        } catch (\Exception $e) {
            throw new GlobalException($e->getCode(), $e->getMessage());
        }
    }



    /**
     * user login 
     * @param  LoginData $loginData
     * @return Object $result
     */

    public function userLogin(LoginData $loginData)
    {
        $loginData->password = MD5($loginData->password);
        $query = "SELECT id FROM users WHERE email='$loginData->email' AND password = '$loginData->password'";
        try {

            $result  = $this->executeQueryForObject($query);
            if (!empty($result))
                return $result;
            else
                throw new GlobalException(GlobalException::INVALID_LOGIN, "Invalid credentials");
        } catch (\Exception $e) {
            throw new GlobalException($e->getCode(), $e->getMessage());
        }
    }



    /**
     * delete a user
     * @param  int $id
     * @return null
     */

    public function deleteUser(int $id)
    {

        if (!empty($id)) {
            $query = "DELETE FROM users WHERE id='$id';";
            try {
                $this->executeQuery($query);
                return null;
            } catch (\Exception $e) {
                throw new GlobalException($e->getCode(), $e->getMessage());
            }
        } else
            throw new GlobalException(GlobalException::EMPTY_PARAMETERS, "id is empty! Please enter a id");
    }



    /**
     * show user data
     * @param  int $id
     * @return Users
     */

    public function userdetails(int $id)
    {
        if (!empty($id)) {
            $query = "SELECT name,email,phone FROM users WHERE id='$id';";

            try {
                $user = $this->executeQueryForObject($query);
                if (!empty($user))
                    return $user;

                throw new GlobalException(GlobalException::USER_NOT_FOUND, "User not found");
            } catch (\Exception $e) {
                throw new GlobalException($e->getCode(), $e->getMessage());
            }
        } else
            throw new GlobalException(GlobalException::EMPTY_PARAMETERS, "id is empty! Please enter a id");
    }




    /**
     * Validate User data Before Saving
     * @param Users $user
     * @return NULL
     */


    private function validateSaveUser(User $user)
    {
        if (empty($user->name))
            throw new GlobalException(GlobalException::EMPTY_PARAMETERS, "Name is empty! Please enter a name");


        if (empty($user->email))
            throw new GlobalException(GlobalException::EMPTY_PARAMETERS, "Email is empty! Please enter a email");
        else if (!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/", $user->email))
            throw  new GlobalException(GlobalException::INVALID_PARAMETERS, "Enter a valid email address");


        if (empty($user->phone))
            throw new GlobalException(GlobalException::EMPTY_PARAMETERS, "Phone number is empty! Please enter a phone number");


        if (empty($user->password))
            throw new GlobalException(GlobalException::EMPTY_PARAMETERS, "Password is empty! Please enter a password");
        else if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/", $user->password))
            throw new GlobalException(GlobalException::INVALID_PARAMETERS, 
            "At least 8 characters,
            Contains at least one uppercase letter,
            Contains at least one lowercase letter,
            Contains at least one number,
            Contains at least one special character");
    }
}
