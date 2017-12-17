<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegister extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Username', TextType::class)
            ->add('Password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => array('attr' => array('class' => 'password-field')),
                'required' => true,
                'first_options'  => array('label' => 'Password '),
                'second_options' => array('label' => 'Confirm Password '),))
            ->add('Select_first_Castle', ChoiceType::class, array(
                'choices'  => array(
                    'Dark' => array(
                        'Dwarf' => 'Dwarf',
                        'Ninja' => 'Ninja',
                        'Vampire' => 'Vampire'
                    ),
                    'Light' => array(
                        'Elves' => 'Elves',
                        'Mages' => 'Mages',
                        'Olymp' => 'Olymp'
                    ),
                    ),
                ))
            ->add('Select_second_Castle', ChoiceType::class, array(
                'choices'  => array(
                    'Dark' => array(
                        'Dwarf' => 'Dwarf',
                        'Ninja' => 'Ninja',
                        'Vampire' => 'Vampire'
                    ),
                    'Light' => array(
                        'Elves' => 'Elves',
                        'Mages' => 'Mages',
                        'Olymp' => 'Olymp'
                    ),
                ),
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'app_bundle_user_register';
    }
}
