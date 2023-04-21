<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'username',
                TextType::class,
                [
                    'label' => "Nom d'utilisateur",
                    'attr' => array('class' => 'form-control')
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => 'Adresse email',
                    'attr' => array('class' => 'form-control')
                ]
            )
            ->add(
                'password',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'invalid_message' => 'Les deux mots de passe doivent correspondre.',
                    'required' => true,
                    'first_options'  => ['label' => 'Mot de passe','attr' => array('class' => 'form-control')],
                    'second_options' => ['label' => 'Tapez le mot de passe à nouveau','attr' => array('class' => 'form-control')],
                ]
            )
            ->add(
                'roles',
                ChoiceType::class,
                [
                    'label' => 'Role de l\'utilisateur',
                    'choices' => [
                        'ROLE_ADMIN' => 'ROLE_ADMIN',
                        'ROLE_USER' => 'ROLE_USER',
                    ],
                    'choice_attr' => [
                        'ROLE_ADMIN' => ['class' => 'form-check-input'],
                        'ROLE_USER' => ['class' => 'form-check-input'],
                    ],
                    'required' => true,
                    'multiple' => true,
                    'expanded' => true,
                ]
            );
    }
}
