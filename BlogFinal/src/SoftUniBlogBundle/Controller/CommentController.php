<?php

namespace SoftUniBlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SoftUniBlogBundle\Entity\Article;
use SoftUniBlogBundle\Entity\Comment;
use SoftUniBlogBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends Controller
{
    /**
     * @Route("/article/{id}/comment", name="add_comment", methods={"POST"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addComment(Request $request, Article $article)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        $comment->setArticle($article);
        $comment->setAuthor($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();

        return $this->redirectToRoute('article_view',
            ['id'=>$article->getId()]);
    }
}
