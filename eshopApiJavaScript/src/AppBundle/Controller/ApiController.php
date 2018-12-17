<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 * Class ApiController
 * @package AppBundle\Controller
 */
class ApiController extends Controller
{
    /**
     * @Route("/products", methods={"GET","HEAD"})
     * @return Response
     */
    public function getProductsAction()
    {
        $products = $this
            ->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();
        return $this->response($products, 200);
    }

    /**
     * @Route("/products", methods={"POST"})
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function createProductAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        //$form->handleRequest($request);
        $form->submit($request->request->all());

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();
        return $this->response($product, 201);

    }

    /**
     * @Route("/products/{id}", methods={"GET"})
     * @param int $id
     * @return Response
     */
    public function getProductAction(int $id){
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);
        if(!$product){
            throw $this->createNotFoundException("Product not found");
        }

        return $this->response($product,200);
    }

    /**
     * @Route("/products/edit/{id}", methods={"PUT"})
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function updateProductAction(int $id, Request $request){
        $product = $this
            ->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);
        if(!$product){
            throw $this->createNotFoundException("Product not found");
        }
        $form = $this->createForm(ProductType::class, $product);
        $form->submit($request->request->all());

        $em = $this
            ->getDoctrine()
            ->getManager();
        $em->merge($product);
        $em->flush();

        return $this->response($product, 200);

    }

    /**
     * @Route("/products/delete/{id}", methods={"DELETE"})
     * @param int $id
     * @return Response
     */
    public function deleteProductAction(int $id){
        $product = $this
            ->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);
        if(!$product){
            throw $this->createNotFoundException("Product not found");
        }

        $em = $this
            ->getDoctrine()
            ->getManager();
        $em->remove($product);
        $em->flush();

        return $this->response($product, 200);

    }

    /**
     * @Route("/countries", methods={"GET"})
     * @return Response
     */
    public function getCountries(Request $request){
        /** @var Connection $db */
        //term is typed by the user-searched word
        $term = $request->get('term');
        $db = $this->getDoctrine()->getConnection();
        $countries = $db->fetchAll("SELECT country_name
                                        FROM geography.countries
                                        WHERE country_name 
                                        LIKE :term
                                        LIMIT 20",['term'=>$term . '%']);
        return $this->response($countries,200);
    }

    private function response($data, $status) :Response
    {
        $serializator = $this->get('jms_serializer');
        return new Response(
            $serializator->serialize($data, 'json'),
            $status,
            ['Content-Type' => 'Application/json']
        );
    }

}
