<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 10.12.2018 г.
 * Time: 16:10
 */

namespace AppBundle\Service\Product;


interface ProductServiceInterface
{
    public function getCountWithUser();

    public function createProduct($product);

    public function showAllProducts() :array;

    public function showOneProduct($name);
}