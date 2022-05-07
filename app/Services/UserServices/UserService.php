<?php

namespace App\Services\UserServices;
use App\Models\User;

class UserService
{
    private $userFactoryService;

    /**
     * UserService constructor.
     */
    public function __construct()
    {
        $this->userFactoryService = new UserFactoryService();
    }

    /**
     * @param array $params
     * @return User|bool
     */
    public function createUser(array $params)
    {
        if (!User::checkEmailExists($params['email'])){
            return $this->userFactoryService->create($params);
        }
        return false;
    }

    public function deleteUser($id)
    {
        if(User::checkIdExists($id)){
            User::destroy($id);
            return true;
        }
        return false;
    }

    public function getAll()
    {
        return User::all();
    }

    public function UpdateUser($id, $name)
    {
        if(User::checkIdExists($id)){
            $user = User::find($id);
            $user->name = $name;
            $user->save();

            return true;
        }

        return false;
    }

    public function showUser($id)
    {
        if(User::checkIdExists($id)){
            return User::find($id);
        }
        return false;
    }

}