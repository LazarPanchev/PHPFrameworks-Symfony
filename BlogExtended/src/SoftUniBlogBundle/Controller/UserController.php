<?php

namespace SoftUniBlogBundle\Controller;

use SoftUniBlogBundle\Entity\Role;
use SoftUniBlogBundle\Entity\User;
use SoftUniBlogBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        $user= new User();
        $form=$this
            ->createForm(UserType::class,$user);
        $form->handleRequest($request);

        if($form->isSubmitted()){

            //$email=$user->getEmail();
            $email=$form->getData()->getEmail();

            $requiredUser=$this
                ->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy(['email'=>$email]);

            if(!is_null($requiredUser)){
                $this->addFlash("message","Username with email: $email already taken!");
                return $this->render("user/register.html.twig");
            }

            $password= $this
                ->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $role=$this
                ->getDoctrine()
                ->getRepository(Role::class);
            $userRole=$role->findOneBy(['name'=>'ROLE_USER']);
            $user->addRole($userRole);

            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute("security_login");
        }

        return $this->render('user/register.html.twig');
    }

    /**
     * @Route("/profile", name="user_profile")
     */
    public function profileAction(){
        $currentUser= $this->getUser();
        if($currentUser===null){
            return $this->redirectToRoute('blog_index');
        }

        return $this->render("user/profile.html.twig",['user'=>$currentUser]);
    }
}
