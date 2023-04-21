<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'label' => 'Titre:',
                    'attr' => array('class' => 'form-control')
                    ]
            )
            ->add(
                'content',
                TextareaType::class,
                [
                    'label' => 'Contenu:',
                    'attr' => array('class' => 'form-control')
                    ]
            )
            ->add(
                'hasDeadLine',
                CheckboxType::class,
                [
                    'label' => "Ajouter une 'dead-line' ?",
                    'required' => false,
                    'attr' => array('class' => 'form-check')
                ]
            )
            ->add(
                'deadLine',
                DateType::class,
                [
                    'label' => "Date limite",
                    'required' => false,
                    'data'   => new \DateTime(),
                    'attr'  => array(
                        'min' => ( new \DateTime() )->format('d-m-Y'),
                        'class' => '')
                ]
            )
        ;
    }
}
