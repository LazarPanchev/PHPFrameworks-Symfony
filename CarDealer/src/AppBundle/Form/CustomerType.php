<?php

namespace AppBundle\Form;

use AppBundle\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,
                array('attr'=>array('class'=>'form-control')))
            ->add('birthdate', DateType::class,
                array('widget'=>'single_text'))
            ->add('Save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault("data-class", Customer::class);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_customer_type';
    }
}
