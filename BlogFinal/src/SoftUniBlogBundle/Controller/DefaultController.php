<?php

namespace SoftUniBlogBundle\Controller;

use Doctrine\ORM\Mapping\OrderBy;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SoftUniBlogBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    const ARTICLES_PER_PAGE = 4;
    /**
     * @Route("/", name="blog_index")
     */
    public function indexAction(Request $request)
    {
        $articles=$this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->findBy([],['viewCount'=>'desc', 'dateAdded'=>'desc']);

        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $articles, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            self::ARTICLES_PER_PAGE/*limit per page*/
        );

        return $this->render('default/index.html.twig',
            ['pagination'=>$pagination]);
    }
}
