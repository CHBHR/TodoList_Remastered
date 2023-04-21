<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SignUpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => 'Email:',
                    'attr' => ['class' => 'form-control'],
                    ]
            )
            ->add(
                'username',
                TextType::class,
                [
                    'label' => "Nom d'utilisateur:",
                    'attr' => ['class' => 'form-control'],
                    ]
            )
            ->add(
                'password',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'invalid_message' => 'Les deux mots de passe doivent correspondre.',
                    'required' => true,
                    'first_options' => ['label' => 'Mot de passe:', 'attr' => ['class' => 'form-control']],
                    'second_options' => ['label' => 'Confirmer le mot de passe:', 'attr' => ['class' => 'form-control']],
            ]
            )
        ;
    }
}
