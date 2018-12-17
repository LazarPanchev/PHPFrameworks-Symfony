<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Camera;
use AppBundle\Form\CameraType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CameraController extends Controller
{
    /**
     * @Route("/camera", name="camera_all")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAllAction()
    {
        $cameras = $this->getDoctrine()
            ->getRepository(Camera::class)
            ->findAll();
        return $this->render('camera/all.html.twig',
            ['cameras' => $cameras]);
    }

    /**
     * @Route("/camera/create", name="camera_create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $camera = new Camera();
        $form = $this->createForm(CameraType::class, $camera);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if (!$form->isValid()) {
                $errors = ($form->getErrors(true, true));
                return $this->render('camera/create.html.twig',
                    ['form' => $form->createView(), 'errors' => $errors]);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($camera);
            $em->flush();

            return $this->redirectToRoute('camera_all');
        }

        return $this->render("camera/create.html.twig",
            ['form' => $form->createView()]);
    }
}
