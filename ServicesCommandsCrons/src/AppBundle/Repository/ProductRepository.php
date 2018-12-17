<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends \Doctrine\ORM\EntityRepository
{
    //in every repo this
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em,
            new Mapping\ClassMetadata(Product::class));
    }
}
