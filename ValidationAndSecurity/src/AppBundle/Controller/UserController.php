<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends Controller
{
    /**
     * @Route("users/all", name="users_all")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAllAction()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('users/all.html.twig',
            ['users' => $users]);
    }

    /**
     * @Route("/users/create", name="users_create")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request,UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if (!$form->isValid()) {
                $errors = ($form->getErrors(true, true));
                return $this->render('users/create.html.twig',
                    ['form' => $form->createView(), 'errors' => $errors]);
            }else{
                $requiredUsername=$this
                    ->getDoctrine()
                    ->getRepository(User::class)
                    ->findBy(['username'=>$user->getUsername()]);
                if($requiredUsername){
                    $this->addFlash('error','Such Username '. $requiredUsername[0]->getUsername() . ' already exists!');
                    return $this->render('users/create.html.twig',
                        ['form'=>$form->createView()]);
                }

                $requiredEmail=$this
                    ->getDoctrine()
                    ->getRepository(User::class)
                    ->findBy(['email'=>$user->getEmail()]);
                if($requiredEmail){
                    $this->addFlash('error','Such Email already exists!');
                    return $this->render('users/create.html.twig',
                        ['form'=>$form->createView()]);
                }

                $requiredPhone=$this
                    ->getDoctrine()
                    ->getRepository(User::class)
                    ->findBy(['phone'=>$user->getPhone()]);
                if($requiredPhone){
                    $this->addFlash('error','Such Phone number already exists!');
                    return $this->render('users/create.html.twig',
                        ['form'=>$form->createView()]);
                }
                // whatever *your* User object is
                $password = $passwordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('users_all');
            }
        }

        return $this->render("users/create.html.twig",
            ['form' => $form->createView()]);
    }
}
