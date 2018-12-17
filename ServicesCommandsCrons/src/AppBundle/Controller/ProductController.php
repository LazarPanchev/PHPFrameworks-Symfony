<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use AppBundle\Service\Product\ProductServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends Controller
{
    /**
     * @var ProductServiceInterface
     */
    private $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @Route("/products", name="products_users")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allUsersAndProducts()
    {
        return $this->render('app/index.html.twig',
            ['count' => $this->productService->getCountWithUser()]);
    }

    /**
     * @Route("/products/create", name="products_create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createProductAction(Request $request)
    {
        $product= new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->productService->createProduct($product);
                return $this->redirectToRoute("products_users");
            }
        }

        return $this->render("products/create.html.twig",
            ['form' => $form->createView()]);
    }

    /**
     * @Route("/products/view", name="products_view")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewProductsAction()
    {
        $products = $this->productService->showAllProducts();

        return $this->render("products/view.html.twig",
            ['producs'=>$products]);
    }

    /**
     * @Route("/products/view/one/{name}", name="products_view_one")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewProductAction($name)
    {
        $product = $this->productService->showOneProduct($name);

        return $this->render("products/viewOne.html.twig",
            ['product'=>$product]);
    }
}
