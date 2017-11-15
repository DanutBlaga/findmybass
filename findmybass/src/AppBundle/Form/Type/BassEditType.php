<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 15.11.2017
 * Time: 17:13
 */

namespace AppBundle\Form\Type;


use AppBundle\Entity\Bass;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BassEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Year', IntegerType::class, [
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:5px']])
            ->add('manufacturingPlace', TextType::class, [
                'label' => 'Manufacturing Place', 'attr' => ['class' => 'form-control', 'style' =>'margin-bottom:5px']])
            ->add('CurrentLocation', TextType::class, [
                'label' => 'Current Location', 'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:5px']])
            ->add('Description', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:5px']])
            ->add('Submit', SubmitType::class, [
                'label' => 'Edit Bass', 'attr' => ['class' => 'btn btn-success']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bass::class
        ]);
    }
}