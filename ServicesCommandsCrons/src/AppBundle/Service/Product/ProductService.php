<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 10.12.2018 г.
 * Time: 16:10
 */

namespace AppBundle\Service\Product;


use AppBundle\Entity\Product;
use AppBundle\Repository\ProductRepository;
use AppBundle\Service\User\UserServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class ProductService implements ProductServiceInterface
{
    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * ProductService constructor.
     * @param UserServiceInterface $userService
     * @param EntityManagerInterface $entityManager
     * @param ProductRepository $productRepository
     */
    public function __construct(UserServiceInterface $userService,
                                EntityManagerInterface $entityManager,
                                ProductRepository $productRepository)
    {
        $this->userService = $userService;
        $this->entityManager=$entityManager;
        $this->productRepository=$productRepository;
    }


    public function getCountWithUser()
    {
        return $this->userService->findValidUsers();
    }

    public function createProduct($product)
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }

    public function showAllProducts():array
    {
        return $this->productRepository->findAll();
    }

    public function showOneProduct($name)
    {
        return $this->productRepository->findOneBy(['name'=>$name]);
    }
}