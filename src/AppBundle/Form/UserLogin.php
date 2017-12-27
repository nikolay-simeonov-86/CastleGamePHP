<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserLogin extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('_username', TextType::class)
            ->add('_password', PasswordType::class)
            ->add('_csrf_token', HiddenType::class)
            ->add('LOGIN', SubmitType::class, array(
                'label' => 'LOGIN'
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }
}
