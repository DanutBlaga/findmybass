<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 20.10.2017
 * Time: 13:35
 */

namespace AppBundle\Form\Type;


use AppBundle\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Username', TextType::class, [
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:5px']
            ])
            ->add('Password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options' => ['label' => 'Password', 'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:5px']],
                'second_options' => ['label' => 'Repeat Password', 'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:5px']]
            ])
            ->add('BirthDate', DateType::class, [
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y')-70),
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:5px']
            ])
            ->add('Email', EmailType::class, [
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:5px']
            ])
            ->add('Submit', SubmitType::class, [
                'label' => 'Register', 'attr' => ['class' => 'btn btn-success']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' =>Users::class,
        ]);
    }
}