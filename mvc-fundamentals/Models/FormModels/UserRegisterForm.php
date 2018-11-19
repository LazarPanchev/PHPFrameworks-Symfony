<?php
/**
 * Created by IntelliJ IDEA.
 * User: RoYaL
 * Date: 13.11.2018 г.
 * Time: 16:45
 */

namespace Models\FormModels;


class UserRegisterForm
{
    private $username;

    private $password;

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }


}