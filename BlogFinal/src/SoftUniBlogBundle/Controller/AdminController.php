<?php

namespace SoftUniBlogBundle\Controller;

use SoftUniBlogBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin_panel")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $users=$this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();
        return $this->render('user/admin.html.twig',
            ['users'=>$users]);
    }

    /**
     * @Route("/admin/{id}", name="admin_view")
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(User $user)
    {
        return $this->render('user/admin_view.html.twig',
            ['user'=>$user]);
    }
}
