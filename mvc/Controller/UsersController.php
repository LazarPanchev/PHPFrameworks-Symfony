<?php

namespace Controller;

use Core\View\ViewInterface;
use Model\UserRegisterFormModel;
use Model\UserProfileViewModel;
use Service\UserService;

class UsersController extends ControllerAbstract
{
    public function profile(string $firstName, string $lastName)
    {
        $model = new UserProfileViewModel($firstName, $lastName);
        $this->render($model);
    }

    public function register()
    {
        $this->render();
    }

    public function registerSave(UserRegisterFormModel $userModel)
    {
        $userService= new UserService();
        $userService->register($userModel);
        echo 'registering....' . $user->getUsername() . ' with ' .
        "password " . $user->getPassword();

    }

}