<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
//        $products=$this
//            ->getDoctrine()
//            ->getRepository(Product::class)
//            ->findAll();
        $products=$this->getDoctrine()->getRepository(Product::class)
            ->getList();

        return $this->render('default/index.html.twig',
            ['products'=>$products]);
    }

    /**
     * @Route("/create", name="products_create")
     * @throws \Exception
     */
    public function createAction(Request $request)
    {
        $product=new Product();
        $form=$this->createForm(ProductType::class,$product);
        $form->handleRequest($request);


        if($form->isSubmitted()){
            //we have validations errors from the ProductType
            if(!$form->isValid()){
               $errors = ($form->getErrors(true,true));

                return $this->render('products/create.html.twig',
                    ['form'=>$form->createView(), 'errors'=>$errors]);
            }

            $em=$this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }


        return $this->render('products/create.html.twig',
            ['form'=>$form->createView(),'errors'=>[]]);
    }

    /**
     * @Route("/view/{name}", name="products_view")
     * @param string $name
     * @param Connection $connection
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(string $name, Connection $connection)
    {
        try {
            $product = $this
                ->getDoctrine()
                ->getRepository(Product::class)
                ->getByName($name, $connection);
            return $this->render('default/view.html.twig',
                ['product'=>$product]);
        } catch (DBALException $e) {
            dump($e);
            exit();
        }


    }

    /**
     * @Route("/create", name="products_create")
     * @throws \Exception
     */

    /**
     * @Route("/edit/{id}", name="products_edit")
     * @param Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, int $id)
    {
        $product=$this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);

        $form=$this->createForm(ProductType::class,$product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }


        return $this->render('products/create.html.twig',
            ['form'=>$form->createView()]);
    }

    /**
     * @Route("/delete/{id}", name="products_delete")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(int $id)
    {
        $product=$this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);

            $em=$this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();

            return $this->redirectToRoute('homepage');
    }
}
