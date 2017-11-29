<?php

namespace AppBundle\Form\Type;


use AppBundle\Entity\Bass;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            ->add('MakeName', TextType::class, [
               'label' => 'Make Name', 'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:5px']])
            ->add('ModelName', TextType::class, [
                'label' => 'Model Name', 'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:5px']])
            ->add('Year', IntegerType::class, [
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:5px']])
            ->add('manufacturingPlace', TextType::class, [
                'label' => 'Manufacturing Place', 'attr' => ['class' => 'form-control', 'style' =>'margin-bottom:5px']])
            ->add('CurrentLocation', TextType::class, [
                'label' => 'Current Location', 'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:5px']])
            ->add('Description', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:5px']])
            ->add('PictureFile', FileType::class, [
                'label' => 'Upload Image'])
            ->add('Submit', SubmitType::class, [
                'label' => 'Add Bass', 'attr' => ['class' => 'btn btn-success']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bass::class,
        ]);
    }
}