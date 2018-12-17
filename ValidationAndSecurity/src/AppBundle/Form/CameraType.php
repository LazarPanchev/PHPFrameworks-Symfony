<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CameraType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('make', ChoiceType::class,
                ['choices'=>[
                    ''=>null,
                    'Canon'=>'Canon',
                    'Nikon'=>'Nikon',
                    'Penta'=>'Penta',
                    'Sony'=>'Sony']
                ])
            ->add('model', TextType::class)
            ->add('price', NumberType::class)
            ->add('quantity', NumberType::class)
            ->add('minShutterSpeed', NumberType::class)
            ->add('maxShutterSpeed', NumberType::class)
            ->add('minIso', NumberType::class)
            ->add('maxIso', NumberType::class)
            ->add('isFullFrame',ChoiceType::class,
                ['choices'=>[
                    ''=>null,
                    'yes'=>'yes',
                    'no'=>'no']
                ] )
            ->add('videoResolution', TextType::class)
            ->add('lightMetering',ChoiceType::class,
                ['choices'=>[
                    ''=>null,
                    'spot'=>'spot',
                    'center-weighted'=>'center-weighted',
                    'evaluative'=>'evaluative']
                ] )
            ->add('description', TextType::class)
            ->add('imageUrl', TextType::class)
            ->add('save', SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Camera'
        ));
    }
}
