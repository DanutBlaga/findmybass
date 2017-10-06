<?php

namespace AppBundle\Form\Type;


use AppBundle\Entity\Bass;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BassType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('MakeName', TextType::class)
            ->add('ModelName', TextType::class)
            ->add('Year', IntegerType::class)
            ->add('manufacturingPlace', TextType::class)
            ->add('CurrentLocation', TextType::class)
            ->add('Description', TextareaType::class)
            ->add('Submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bass::class,
        ]);
    }
}