<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Camera
 *
 * @ORM\Table(name="cameras")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CameraRepository")
 */
class Camera
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
     * @ORM\Column(name="make", type="string", length=255)
     *
     * @Assert\Choice(
     *     choices={"Canon", "Nikon", "Penta", "Sony"},
     *     message="Choose a valid make."
     * )
     */
    private $make;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/^[A-Z0-9\-]+$/",
     *     match=false,
     *     message="Your model can contains only upper case letters, digits and dashes. Cannot be empty!"
     * )
     */
    private $model;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     * @Assert\NotBlank()
     * @Assert\Type(
     *     type="float",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     * @Assert\Range(
     *      min = 0,
     *      max = 100,
     *      minMessage = "Quantity can't be negative number!",
     *      maxMessage = "Quantity can't be more than 100!"
     * )
     */
    private $quantity;

    /**
     * @var int
     *
     * @ORM\Column(name="minShutterSpeed", type="integer")
     * @Assert\Range(
     *      min = 1,
     *      max = 30,
     *      minMessage = "Min shutter speed can't be smaller than 1",
     *      maxMessage = "Min shutter speed can't be greater than 30"
     * )
     *
     */
    private $minShutterSpeed;

    /**
     * @var int
     *
     * @ORM\Column(name="maxShutterSpeed", type="integer")
     * @Assert\Range(
     *      min = 2000,
     *      max = 8000,
     *      minMessage = "Max shutter speed can't be smaller than 2000",
     *      maxMessage = "Max shutter speed can't be greater than 8000"
     * )
     */
    private $maxShutterSpeed;

    /**
     * @var int
     *
     * @ORM\Column(name="minIso", type="integer")
     * @Assert\Range(
     *      min = 50,
     *      max = 100,
     *      minMessage = "You must be at least {{ limit }}",
     *      maxMessage = "You cannot be taller than {{ limit }}"
     * )
     */
    private $minIso;

    /**
     * @var int
     *
     * @ORM\Column(name="maxIso", type="integer")
     * @Assert\Range(
     *      min = 200,
     *      max =409600,
     *      minMessage = "Max iso can't be lower than 200",
     *      maxMessage = "Max iso can't be greater than 409600"
     * )
     *
     */
    private $maxIso;

    /**
     * @var bool
     *
     * @ORM\Column(name="isFullFrame", type="boolean")
     *
     * @Assert\Choice(choices={"yes", "no"}, message="Choose yes or no.")
     */
    private $isFullFrame;

    /**
     * @var string
     *
     * @ORM\Column(name="videoResolution", type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(
     *      max = 15,
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $videoResolution;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="lightMetering", type="string", length=255)
     * @Assert\Choice(choices={"spot", "center-weighted", "evaluative"}, message="Choose appropriate light metering")
     */
    private $lightMetering;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="description", type="text")
     * @Assert\Length(
     *      max = 6000,
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="imageUrl", type="text")
     * @Assert\Url(
     *     protocols={"http","https"},
     *     message="Your imageUrl is not valid. Please try with a valid URL."
     * )
     */

    private $imageUrl;


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
     * Set make
     *
     * @param string $make
     *
     * @return Camera
     */
    public function setMake($make)
    {
        $this->make = $make;

        return $this;
    }

    /**
     * Get make
     *
     * @return string
     */
    public function getMake()
    {
        return $this->make;
    }

    /**
     * Set model
     *
     * @param string $model
     *
     * @return Camera
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Camera
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
     * @return Camera
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
     * Set minShutterSpeed
     *
     * @param integer $minShutterSpeed
     *
     * @return Camera
     */
    public function setMinShutterSpeed($minShutterSpeed)
    {
        $this->minShutterSpeed = $minShutterSpeed;

        return $this;
    }

    /**
     * Get minShutterSpeed
     *
     * @return int
     */
    public function getMinShutterSpeed()
    {
        return $this->minShutterSpeed;
    }

    /**
     * Set maxShutterSpeed
     *
     * @param integer $maxShutterSpeed
     *
     * @return Camera
     */
    public function setMaxShutterSpeed($maxShutterSpeed)
    {
        $this->maxShutterSpeed = $maxShutterSpeed;

        return $this;
    }

    /**
     * Get maxShutterSpeed
     *
     * @return int
     */
    public function getMaxShutterSpeed()
    {
        return $this->maxShutterSpeed;
    }

    /**
     * Set minIso
     *
     * @param integer $minIso
     *
     * @return Camera
     */
    public function setMinIso($minIso)
    {
        $this->minIso = $minIso;

        return $this;
    }

    /**
     * Get minIso
     *
     * @return int
     */
    public function getMinIso()
    {
        return $this->minIso;
    }

    /**
     * Set maxIso
     *
     * @param integer $maxIso
     *
     * @return Camera
     */
    public function setMaxIso($maxIso)
    {
        $this->maxIso = $maxIso;

        return $this;
    }

    /**
     * Get maxIso
     *
     * @return int
     */
    public function getMaxIso()
    {
        return $this->maxIso;
    }

    /**
     * Set isFullFrame
     *
     * @param boolean $isFullFrame
     *
     * @return Camera
     */
    public function setIsFullFrame($isFullFrame)
    {
        $this->isFullFrame = $isFullFrame;

        return $this;
    }

    /**
     * Get isFullFrame
     *
     * @return bool
     */
    public function getIsFullFrame()
    {
        return $this->isFullFrame;
    }

    /**
     * Set videoResolution
     *
     * @param string $videoResolution
     *
     * @return Camera
     */
    public function setVideoResolution($videoResolution)
    {
        $this->videoResolution = $videoResolution;

        return $this;
    }

    /**
     * Get videoResolution
     *
     * @return string
     */
    public function getVideoResolution()
    {
        return $this->videoResolution;
    }

    /**
     * Set lightMetering
     *
     * @param string $lightMetering
     *
     * @return Camera
     */
    public function setLightMetering($lightMetering)
    {
        $this->lightMetering = $lightMetering;

        return $this;
    }

    /**
     * Get lightMetering
     *
     * @return string
     */
    public function getLightMetering()
    {
        return $this->lightMetering;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Camera
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set imageUrl
     *
     * @param string $imageUrl
     *
     * @return Camera
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Get imageUrl
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }
}

