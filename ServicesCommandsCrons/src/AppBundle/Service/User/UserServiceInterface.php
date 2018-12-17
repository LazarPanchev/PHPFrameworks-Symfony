<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 9.12.2018 г.
 * Time: 11:37
 */

namespace AppBundle\Service\User;


use AppBundle\Entity\User;

interface UserServiceInterface
{
    public function register($username, $password, $birthPlace);

    public function findValidUsers();

    public function find($id);

    public function save(User $user);

    public function findAll();

}