<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sale
 *
 * @ORM\Table(name="sales")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SaleRepository")
 */
class Sale
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="discount", type="float")
     */
    private $discount;

    /**
     * @var int
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Car")
     * @ORM\JoinColumn(name="car_id", referencedColumnName="id")
     */
    private $car;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Customer", inversedBy="sales")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    private $customer;


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
     * Set discount
     *
     * @param float $discount
     *
     * @return Sale
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     *
     * @return float
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @return int
     */
    public function getCar()
    {
        return $this->car;
    }

    /**
     * @param int $car
     */
    public function setCar($car)
    {
        $this->car = $car;
    }

    /**
     * @return int
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param int $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    public function getPriceDiscount(){
        /** @var Car $car */
        $car=$this->car;
        $totalSum = $car->getTotalSum();
        return $totalSum-(($totalSum*$this->discount)/100);
    }

}

