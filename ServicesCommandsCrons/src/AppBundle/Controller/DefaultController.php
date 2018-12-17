<?php

namespace AppBundle\Controller;

use AppBundle\Service\Mail\MailInterface;
use AppBundle\Service\Product\ProductServiceInterface;
use AppBundle\Service\User\UserServiceInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    private $mail;

    private $userService;

    public function __construct(MailInterface $mail, UserServiceInterface $userService)
    {
//        $mail->send('Here');
        $this->mail=$mail;
        $this->userService= $userService;
    }

    /**
     * @Route("/{user}/{pass}/{birthPlace}", name="homepage")
     * @param $user
     * @param $pass
     * @param $birthPlace
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($user,$pass,$birthPlace)
    {
//        $this->mail->send("Hello from indexAction");
        $this->userService->register($user,$pass,$birthPlace);

        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/valid",name="valid_users")
     */
    public function validUsersAction(){
        var_dump($this->userService->findValidUsers());
        exit();
    }
}
