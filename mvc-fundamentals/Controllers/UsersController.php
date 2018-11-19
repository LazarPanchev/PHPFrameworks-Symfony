<?php

namespace Controllers;


use App\Data\UserDTO;
use App\Data\UserLoginDTO;
use App\Service\UserServiceInterface;
use Core\View\ViewInterface;


class UsersController
{
    public function profile(UserServiceInterface $userService, ViewInterface $view)
    {
        if (!isset($_SESSION['id'])) {
            header("Location: /mvc-fundamentals/users/login");
            exit;
        }

        $viewModel = $userService->currentUser();
        $view->render($viewModel);
    }


    public function login(ViewInterface $view)
    {
        $view->render();
    }

    public function loginPost(UserLoginDTO $dto, UserServiceInterface $userService, ViewInterface $view)
    {
        $user = $userService->login($dto->getUsername(), $dto->getPassword());
        if (null !== $user) {
            $_SESSION['id'] = $user->getId();
            header("Location: /mvc-fundamentals/users/profile");
            exit;
        }

        $view->render();
    }

    public function register(ViewInterface $view)
    {
        $view->render();
    }

    public function registerPost(UserDTO $dto,
                                 UserServiceInterface $userService,
                                 ViewInterface $view)
    {
        if ($userService->register($dto)) {
            header("Location: /mvc-fundamentals/users/login");
            exit;
        }

        $view->render("users/register");
    }
}