<?php

namespace AppBundle\Repository;
use Doctrine\DBAL\Connection;


/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends \Doctrine\ORM\EntityRepository
{

    public function getList(){
        $query= $this->getEntityManager()->createQuery(
            "SELECT p, c
                 FROM AppBundle:Product p
                 JOIN p.category c
                 ORDER BY p.name" );
        return ($query->getResult());
    }

    /**
     * @param Connection $connection
     * @param $name
     * @return mixed
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getByName(string $name, $connection){

        $stm = $connection->prepare("SELECT p.name,
                                              p.price, p.description,
                                              c.name AS catName FROM products AS p
                                              INNER JOIN categories AS c
                                              ON p.category_id = c.id
                                              WHERE p.name = :name;");
        $stm->execute([':name'=>$name]);
        return $stm->fetch(\PDO::FETCH_OBJ);
    }
}