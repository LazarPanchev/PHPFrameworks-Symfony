<?php

namespace SoftUniBlogBundle\Controller;

use SoftUniBlogBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="security_login")
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        //get the login error if there is one
        $error= $authenticationUtils->getLastAuthenticationError();

        if($error !== null){
            $this->addFlash("message","Invalid Email or Password!");
        }

        //last username/email entered by the user
        $lastEmail= $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig',
            array('last_username'=>$lastEmail)
        );
    }

    /**
     * @Route("/logout", name="security_logout")
     * @throws \Exception
     */
    public function logoutAction()
    {
        throw new \Exception("Logout failed!");
    }
}
