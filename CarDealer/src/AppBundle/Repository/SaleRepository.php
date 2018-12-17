<?php

namespace AppBundle\Repository;

/**
 * SaleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SaleRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllSales()
    {
        $query = $this
            ->createQueryBuilder('sales')
            ->select('sales', 'car', 'customer')
            ->innerJoin('sales.car', 'car')
            ->innerJoin('sales.customer', 'customer')
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findDetailsSale($id)
    {
        return $this
            ->createQueryBuilder('sales')
            ->select('sales', 'car', 'customer')
            ->innerJoin('sales.car', 'car')
            ->innerJoin('sales.customer', 'customer')
            ->where('sales.id = :id')
            ->setParameter(':id', intval($id))
            ->getQuery()
            ->getSingleResult();

    }

    /**
     * @return array
     */
    public function findDiscounted()
    {
        $query = $this
            ->createQueryBuilder('sales')
            ->select('sales')
            ->where('sales.discount > 0')
            ->getQuery();

        return $query->getResult();

    }

    /**
     * @param string $percent
     * @return mixed
     */
    public function findDiscountedPercent(string $percent)
    {
        $query = $this
            ->createQueryBuilder('sales')
            ->select('sales')
            ->where('sales.discount = :discount')
            ->setParameter(':discount', $percent)
            ->getQuery();

        return $query->getResult();

    }
}