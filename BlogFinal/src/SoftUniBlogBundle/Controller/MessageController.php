<?php

namespace SoftUniBlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SoftUniBlogBundle\Entity\Message;
use SoftUniBlogBundle\Entity\User;
use SoftUniBlogBundle\Form\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends Controller
{
    const MESSAGE_PER_PAGE = 5;

    /**
     * @Route("user/{id}/{articleId}/message", name="user_message")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param int $id
     * @param int $articleId
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(int $id,int $articleId, Request $request)
    {
        $currentUser = $this->getUser();
        $recipient = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        if($currentUser->getId() === $id){
            $this->addFlash("error",
                "You can't send message to yourself!");
            return $this->redirectToRoute('article_view',
                ['id'=>$articleId]);
        }

        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $message
                ->setSender($currentUser)
                ->setRecipient($recipient)
                ->setIsRead(false);
            $em=$this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            $this->addFlash("message","Message to " . $recipient->getFullName() . " send successfully!");
//        return $this->render('user/send_message.html.twig',
//            ['form'=>$form->createView()]);
           return $this->redirectToRoute('article_view',
                ['id'=>$articleId]);
        }

        return $this->render('user/send_message.html.twig',
            ['form'=>$form->createView()]);

    }

    /**
     * @Route("/user/mailbox", name="user_mailbox")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mailBoxAction(Request $request)
    {
        $currentUser=$this->getUser();
        //$messages=$currentUser->getRecipientMessages();
        $messages=$this
            ->getDoctrine()
            ->getRepository(Message::class)
            ->findBy(['recipient'=>$currentUser->getId(0)],['dateAdded'=>'DESC']);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $messages, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            self::MESSAGE_PER_PAGE/*limit per page*/
        );
        return $this->render('user/mailbox.html.twig',
            ['pagination'=>$pagination]);
    }

    /**
     * @Route("/user/mailbox/{id}", name="user_mailbox_one")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function oneMessageAction(int $id, Request $request)
    {
        /** @var Message $message */
        $message=$this
            ->getDoctrine()
            ->getRepository(Message::class)
            ->find($id);
        $message->setIsRead(true);
        $em=$this->getDoctrine()->getManager();
        $em->merge($message);
        $em->flush();

        $newMessage = new Message();
        $form = $this->createForm(MessageType::class, $newMessage);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $recipient=$message->getSender();
            $newMessage
                ->setSender($this->getUser())
                ->setRecipient($recipient)
                ->setIsRead(false);
            $em->persist($newMessage);
            $em->flush();

            $this->addFlash("message","Message to " . $recipient->getFullName() . " send successfully!");

            return $this->redirectToRoute('user_mailbox_one',
                ['id'=>$id]);


        }
        return $this->render('user/one_message.html.twig',
            ['msg'=>$message, 'form'=>$form->createView()]);
    }


}
