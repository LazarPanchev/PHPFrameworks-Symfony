<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Car;
use AppBundle\Form\CarType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends Controller
{
    /**
     * @Route("/cars/find/{make}", name="cars_all", methods={"GET"})
     * @param string $make
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allCarsAction(string $make)
    {
        $cars= $this
            ->getDoctrine()
            ->getRepository(Car::class)
            ->findCarsByMake($make);

        return $this->render("cars/all.html.twig",
            ['cars'=>$cars]);
    }

    /**
     * @Route("/cars/{id}/parts", name="cars_one_parts", methods={"GET"})
     * @param string $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getCarWithPartsAction(string $id)
    {
        try{
            $car= $this
                ->getDoctrine()
                ->getRepository(Car::class)
                ->findCarWithParts($id);

            return $this->render("cars/one.html.twig",
                ['car'=> $car]);
        }catch (\Exception $ex){
            dump($ex);
            exit();
        }
    }

    /**
     * @Route("/cars/create", name="cars_create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request){

        $car= new Car();
        $form= $this->createForm(CarType::class,$car);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em= $this->getDoctrine()->getManager();
            $em->persist($car);
            $em->flush();
            return $this->redirectToRoute('cars_one_parts',
                array('id'=>$car->getId()));
        }

        return $this->render("cars/create.html.twig",
            ['form'=>$form->createView()]);

    }
}
