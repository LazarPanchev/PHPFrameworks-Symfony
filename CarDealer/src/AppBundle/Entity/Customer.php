<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Customer
 *
 * @ORM\Table(name="customers")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CustomerRepository")
 */
class Customer
{
    const DRIVER_YEARS = 20;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthDate", type="date")
     */
    private $birthDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isYoungDriver", type="boolean")
     */
    private $isYoungDriver;

    /**
     * @var ArrayCollection|Sale[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Sale", mappedBy="customer")
     *
     */
    private $sales;

    public function __construct()
    {
        $this->sales = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Customer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return Customer
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
        $todayDate=new \DateTime('now');
        $intervalDays=$todayDate->diff($birthDate);
        if($intervalDays->y > self::DRIVER_YEARS){
            $this->isYoungDriver=false;
        }else{
            $this->isYoungDriver=true;
        }
        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set isYoungDriver
     *
     * @param boolean $isYoungDriver
     *
     * @return Customer
     */
    public function setIsYoungDriver($isYoungDriver)
    {
        $this->isYoungDriver = $isYoungDriver;

        return $this;
    }

    /**
     * Get isYoungDriver
     *
     * @return bool
     */
    public function getIsYoungDriver()
    {
        return $this->isYoungDriver ? "Yes" : "No";
    }

    /**
     * @return Sale[]|ArrayCollection
     */
    public function getSales()
    {
        return $this->sales;
    }

    /**
     * @param Sale $sale
     * @return Customer
     */
    public function addSale(Sale $sale)
    {
        $this->sales[] = $sale;
        return $this;
    }

    public function boughtCars()
    {
        return count($this->sales);
    }

    public function totalSpendMoney()
    {
        $totalSum = 0;
        foreach ($this->sales as $sale) {
            /** @var $car Car */
            $car = $sale->getCar();
            $carSum = $car->getTotalSum();
            $totalSum += $carSum;
        }
        return $totalSum;
    }

}

