<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Part
 *
 * @ORM\Table(name="parts")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PartRepository")
 */
class Part
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Supplier", inversedBy="parts")
     * @ORM\JoinColumn(name="supplier_id", referencedColumnName="id")
     */
    private $supplier;

    /**
     * @var ArrayCollection|Car[]
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Car", mappedBy="parts")
     */
    private $cars;


    public function __construct()
    {
        $this->cars=new ArrayCollection();
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
     * @return Part
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
     * Set price
     *
     * @param string $price
     *
     * @return Part
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Part
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;

    }

    /**
     * @return int
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * @param int $supplier
     */
    public function setSupplier($supplier)
    {
        $this->supplier = $supplier;
    }

    /**
     * @return Car[]|ArrayCollection
     */
    public function getCars()
    {
        return $this->cars;
    }

    /**
     * @param Car $car
     * @return Part
     */
    public function addCar(Car $car)
    {
        $this->cars[]=$car;
        return $this;
    }


}

