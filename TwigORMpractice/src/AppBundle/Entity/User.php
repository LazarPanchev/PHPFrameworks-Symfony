<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class User
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank(message="Not black please"})
     */
    private $name;

    /**
     * @var int
     */
    private $age;

    /**
     * @var \datetime
     */
    private $birthDate;

    /**
     * @var string
     */
    private $country;

    /**
     * @var int
     */
    private $cityId;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }

    /**
     * @return int
     */
    public function getCityId()
    {
        return $this->cityId;
    }

    /**
     * @param int $cityId
     */
    public function setCityId($cityId)
    {
        $this->cityId = $cityId;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return \datetime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param \datetime $birthDate
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }
}