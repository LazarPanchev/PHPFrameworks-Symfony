<?php

namespace AppBundle\Form;

use AppBundle\Entity\Supplier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,
                array('attr'=>array('class'=>'form-control')))
            ->add('price', NumberType::class,
                array('attr'=>array('class'=>'form-control')))
            ->add('quantity', NumberType::class,
                array('label' => 'quantity',
                    'data' => '1',
                    'attr'=>array('class'=>'form-control')))
            ->add('supplier', EntityType::class, [
                'class' => Supplier::class,
                'choice_label' => 'name',
                'placeholder' => '',
                'attr'=>array('class'=>'form-control')
            ])
            ->add('save', SubmitType::class,
                array('attr'=>array('class'=>'btn primary')));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Part'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_part';
    }


}
