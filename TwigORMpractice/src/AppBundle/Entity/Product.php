<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 28.11.2018 г.
 * Time: 13:33
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 * @ORM\Table(name="products")
 */
class Product
{
    /**
     * Primary key of the object
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", unique=true)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $color;

    /**
     * @var string
     * @ORM\Column(type="decimal", scale=2)
     */
    private $price;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var \datetime
     * @ORM\Column(type="datetime", name="create_date")
     */
    private $createDate;

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
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }


    /**
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return \datetime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * @param \datetime $createDate
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;
    }
}