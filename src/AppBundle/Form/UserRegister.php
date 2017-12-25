<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('castle1', ChoiceType::class,
                array(
                    'mapped' => false,
                    'choices'  =>
                        array(
                    'Dark' =>
                            array(
                        'Dwarf' => 'Dwarf',
                        'Ninja' => 'Ninja',
                        'Vampire' => 'Vampire'
                                ),
                    'Light' =>
                            array(
                        'Elves' => 'Elves',
                        'Mages' => 'Mages',
                        'Olymp' => 'Olymp'
                                ),
                            ),
                    )
                )
            ->add('castle2', ChoiceType::class,
                array(
                    'mapped' => false,
                    'choices'  =>
                        array(
                            'Dark' =>
                                array(
                                    'Dwarf' => 'Dwarf',
                                    'Ninja' => 'Ninja',
                                    'Vampire' => 'Vampire'
                                ),
                            'Light' =>
                                array(
                                    'Elves' => 'Elves',
                                    'Mages' => 'Mages',
                                    'Olymp' => 'Olymp'
                                ),
                        ),
                )
            )
            ->add('REGISTER', SubmitType::class, array(
                'label' => 'REGISTER'
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'      => User::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // a unique key to help generate the secret token
            'csrf_token_id'   => 'user_item',
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_user_register';
    }
}
