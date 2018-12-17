<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Part;
use AppBundle\Entity\Supplier;
use AppBundle\Form\PartType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class PartController extends Controller
{
    /**
     * Lists all part entities.
     *
     * @Route("/parts", name="parts_index", methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $parts = $em
            ->getRepository('AppBundle:Part')
            ->findAll();

        return $this->render('part/index.html.twig', array(
            'parts' => $parts,
        ));
    }

    /**
     * Creates a new part entity.
     *
     * @Route("/parts/new", name="parts_new", methods={"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $part = new Part();
        $form = $this->createForm(PartType::class, $part);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this
                ->getDoctrine()
                ->getManager();
            $em->persist($part);
            $em->flush();

            return $this->redirectToRoute('parts_index');
        }

        return $this->render('part/new.html.twig', array(
            'part' => $part,
            'form' => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing part entity.
     *
     * @Route("/parts/{id}/edit", name="parts_edit")
     */
    public function editAction(int $id, Request $request)
    {
        $part = $this->getDoctrine()
            ->getRepository(Part::class)
            ->find($id);

        $editForm = $this->createForm(PartType::class, $part);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()
                ->getManager()
                ->flush();

            return $this->redirectToRoute('parts_index');
        }
        return $this->render('part/edit.html.twig',
            ['form'=>$editForm->createView()]);
    }

    /**
     * Deletes a part entity.
     *
     * @Route("/parts/{id}/delete", name="parts_delete")
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(int $id, Request $request)
    {
        $part = $this
            ->getDoctrine()
            ->getRepository(Part::class)
            ->find($id);

        $form = $this->createFormBuilder($part);

        $form->add('name', TextType::class,
            array('attr' => array('class' => 'form-control',
                'disabled' => 'disabled')))
            ->add('price', NumberType::class,
                array('attr' => array('class' => 'form-control',
                    'disabled' => 'disabled')))
            ->add('delete', SubmitType::class,
                array('attr' => array('class' => 'btn primary')));
        $form = $form->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($part);
            $em->flush();
            return $this->redirectToRoute('parts_index');
        }

        return $this->render('part/confirmDelete.html.twig',
            ['form' => $form->createView()]);
    }

}
