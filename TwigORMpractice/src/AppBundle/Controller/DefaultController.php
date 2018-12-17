<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="home")
     */
    public function homeAction(Request $request)
    {
        $user = new User();
        //returns formBuilder
        $form = $this
            ->createFormBuilder($user)
            ->add("id", NumberType::class)
            ->add("name", TextType::class,
                ['attr'=>array('class'=>'tinymce')])
            ->add("age", NumberType::class)
            ->add("birthDate", DateTimeType::class,
                ['widget'=>'single_text'])
            ->add("country",CountryType::class)
            ->add("cityId", ChoiceType::class,
                ['choices' =>
                    ['Pleven' => ['Drujba' => 1, "Storgoziq" => 2],
                        'Varna' => ["Mladost" => 3, "VFU" => 4]
                    ]
                ])
            ->add('Save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted()){
            dump($form->getData());
        }

        return $this->render('default/home.html.twig',
            ['myForm' => $form->createView()]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function aboutAction()
    {
       return $this->render("default/about.html.twig");
    }



}
