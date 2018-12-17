<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends Controller
{
    /**
     * @Route("/products", name="products_all")
     */
    public function getAllAction()
    {
        $products= $this
            ->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();

        return $this->render('products/all.html.twig',
            ['products'=>$products]);
    }

    /**
     * @Route("/products/create", name="products_create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request){
        $product= new Product();
        $form=$this
            ->createFormBuilder($product)
            ->add('name', TextType::class,
                ['attr'=>array('class'=>'input-group','placeholder'=>'Name')])
            ->add('color', TextType::class,
                ['attr'=>array('class'=>'input-group','placeholder'=>'Color')])
            ->add('price', NumberType::class,
                ['attr'=>array('class'=>'input-group','placeholder'=>'Price')])
            ->add('description', TextType::class,
                ['attr'=>array('class'=>'input-group','placeholder'=>'Description')])
            ->add('createDate', DateTimeType::class,
                ['attr'=>array('class'=>'input-group','placeholder'=>'Date')])
            ->add('Save', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$this
                ->getDoctrine()
                ->getManager();
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('products_all');
        }
        return $this->render('products/create.html.twig',
            ['form'=>$form->createView()]);
    }

    /**
     * @Route("/products/view/{id}", name="products_view_one")
     */
    public function viewOneAction(int $id){
        $product=$this->getProduct($id);
        if(null === $product){
            //error
            dump($product);
            exit();
        }

        return $this->render('products/view_one.html.twig',
            ['product'=>$product]);
    }

    /**
     * @Route("/products/edit/{id}", name="products_edit")
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(int $id, Request $request){
        $product=$this->getProduct($id);
        $form=$this
            ->createFormBuilder($product)
            ->add('name', TextType::class,
                ['attr'=>array('class'=>'input-group','value'=>$product->getName())])
            ->add('color', TextType::class,
                ['attr'=>array('class'=>'input-group','value'=>$product->getColor())])
            ->add('price', NumberType::class,
                ['attr'=>array('class'=>'input-group','value'=>$product->getPrice())])
            ->add('description', TextType::class,
                ['attr'=>array('class'=>'input-group','value'=>$product->getDescription())])
            ->add('createDate', DateTimeType::class,
                ['attr'=>array('class'=>'input-group')])
            ->add('Edit', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()) {
            $em = $this
                ->getDoctrine()
                ->getManager();
            $em->merge($product);
            $em->flush();
            return $this->redirectToRoute('products_all');
        }

        return $this->render("products/edit.html.twig",
            ['product'=>$product, 'form'=>$form->createView()]);

    }

    /**
     * @Route("/products/delete/{id}", name="products_delete")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(int $id){
        $product=$this->getProduct($id);
        if(null === $product){
            throw $this->createNotFoundException("Product not found!");
        }

        $em=$this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();
        return $this->redirectToRoute('products_all');
    }

    /**
     * @Route("/products/custom/{color}/{price}", name="products_custom")
     * @param string $color
     * @param string $price
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function customFindAction(string $color, string $price){
        $price=floatval($price);
        $products=$this
            ->getDoctrine()
            ->getRepository(Product::class)
            ->findByColorAndPrice($color,$price);

        return $this->render('products/all.html.twig',
            ['products'=>$products]);
    }

    /**
     * @Route("/products/custom/{price}", name="products_custom_price")
     * @param string $price
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function priceFindAction(string $price){
        $price=floatval($price);
        $products=$this
            ->getDoctrine()
            ->getRepository(Product::class)
            ->findByPrice($price);

        return $this->render('products/all.html.twig',
            ['products'=>$products]);
    }

    //helper method
    private function getProduct($id)
    {
        $product = $this
            ->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);
        return $product;
    }
}
