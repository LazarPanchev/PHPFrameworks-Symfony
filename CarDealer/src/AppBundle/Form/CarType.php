<?php

namespace AppBundle\Form;

use AppBundle\Entity\Part;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('make', TextType::class,
                array('attr'=>array('class'=>'form-control')))
            ->add('model', TextType::class,
                array('attr'=>array('class'=>'form-control')))
            ->add('travelledDistance', NumberType::class,
                array('label' => 'Travelled Distance',
                    'attr'=>array('class'=>'form-control')))
            ->add('parts', EntityType::class, [
                'class' => Part::class,
                'choice_label' => 'name',
                'placeholder' => '',
                'multiple'=>true,
                'attr'=>array('class'=>'form-control')
            ])
            ->add('save', SubmitType::class,
                array('attr'=>array('class'=>'btn primary')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Car'
        ));

    }

    public function getBlockPrefix()
    {
        return 'app_bundle_car_type';
    }
}
