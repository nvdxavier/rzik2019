<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class PlaylistType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plname', TextType::class, ['label' => 'Name of my project',
                'required' => true
            ])
            ->add('datecreatepl', DateType::class, [
                'label' => 'Date of my project',
                'required' => false,
                'format' => 'dd/MM/yyyy',
//                                                               'widget' => 'single_text'
            ])
            ->add('musicfile', CollectionType::class, ['entry_type' => MusicFileType::class,
                'entry_options' => ['label' => true],
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'attr' => ['class' => 'container',
                    'required' => false
                ]
            ])
            ->add('descriptionpl', TextareaType::class, ['label' => 'Description of my project',
                'required' => false])
            ->add('image', FileType::class, ['label' => 'Artwork for my project'])
            ->add('save', SubmitType::class, ['attr' => ['class' => 'save']]);
    }
}
