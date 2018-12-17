<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;


class ProductRepository extends EntityRepository
{
    /**
     * @param string $color
     * @param float $price
     * @return array
     * Custom select products by color and price
     */
    public function findByColorAndPrice(string $color, float $price){
        return $this->findBy([
            'color'=>$color,
            'price'=>$price
        ]);
    }

    /**
     * @param float $price
     * Using DQL syntax
     * @return array
     */
    public function findByPrice(float $price){
        $query = $this
            ->getEntityManager()
            ->createQuery("SELECT p FROM AppBundle:Product AS p
                               WHERE p.price < :price
                               ORDER BY p.price 
                               ASC")
            ->setParameter(':price', $price);

        return $query->getResult();
    }
}