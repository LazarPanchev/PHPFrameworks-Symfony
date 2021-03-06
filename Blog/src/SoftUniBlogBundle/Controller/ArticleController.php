<?php

namespace SoftUniBlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SoftUniBlogBundle\Entity\Article;
use SoftUniBlogBundle\Entity\User;
use SoftUniBlogBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends Controller
{
    /**
     * @Route("/article/create", name="article_create")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $article= new Article();
        $form=$this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $author=$this->getUser();
            $article->setAuthor($author);
            $em= $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('blog_index');
        }

        return $this->render('article/create.html.twig',
            ['form'=>$form->createView()]);
    }


    /**
     * @Route("/article/view/{id}", name="article_view")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewOneAction($id){
        $article=$this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['id'=>$id]);

        return $this->render("article/view.html.twig",
            ['article'=>$article]);
    }

    /**
     * @Route("/article/edit/{id}", name="article_edit")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        $article= $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        if($article === null){
            return $this->redirectToRoute('blog_index');
        }

        /** @var User $currentUser */
        $currentUser=$this->getUser();
        if(!$currentUser->isAuthor($article) && !$currentUser->isAdmin()){
            return $this->redirectToRoute('blog_index');
        }

        $form=$this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em= $this->getDoctrine()->getManager();
            $em->merge($article);
            $em->flush();

            return $this->redirectToRoute('blog_index');
        }

        return $this->render('article/edit.html.twig',
            ['article'=>$article, 'form'=>$form->createView()]);
    }

    /**
     * @Route("/article/delete/{id}", name="article_delete")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request, $id)
    {
        $article= $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        if($article === null){
            return $this->redirectToRoute('blog_index');
        }

        /** @var User $currentUser */
        $currentUser=$this->getUser();
        if(!$currentUser->isAuthor($article) && !$currentUser->isAdmin()){
            return $this->redirectToRoute('blog_index');
        }

        $form=$this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em= $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();

            return $this->redirectToRoute('blog_index');
        }

        return $this->render('article/delete.html.twig',
            ['article'=>$article, 'form'=>$form->createView()]);
    }
}
