<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 9.12.2018 г.
 * Time: 11:38
 */

namespace AppBundle\Service\User;


use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;

class UserService implements UserServiceInterface
{
    const VALID_USER_LENGTH = 5;

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository=$userRepository;
    }

    public function findValidUsers(){
        return $this
            ->userRepository
            ->findByUsernameLength(self::VALID_USER_LENGTH);
    }

    public function register($username, $password, $birthPlace)
    {
        $user = new User();
        $user->setUsername($username);
        $user->setPassword(password_hash($password,PASSWORD_BCRYPT));
        $user->setBirthPlace($birthPlace);
        $this->userRepository->save($user);
    }

    public function find($id)
    {
       return $this->userRepository->find($id);
    }

    public function save(User $user)
    {
        $this->userRepository->save($user);
    }

    public function findAll()
    {
        return $this->userRepository->findAll();
    }
}