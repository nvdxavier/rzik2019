<?php

namespace App\Form;

use App\Entity\Picture;
use App\Entity\PlaylistProject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PlaylistProjectType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('plprojectname', TextType::class, ['label' => 'Name of my project',
                'required' => true
            ])
            ->add('datecreateplproject', DateType::class, [
                'label' => 'Date of my project',
                'required' => false,
                'format' => 'dd/MM/yyyy'
            ])
            ->add('descriptionplproject', TextareaType::class, ['label' => 'Description of my project', 'required' => false])
            ->add('mainpictureplproject', PictureType::class, ['label' => 'Main Artwork for the project'])
            ->add('picturesplproject', CollectionType::class, ['entry_type' => PictureType::class,
                'entry_options' => ['label' => 'Add some pictures for your project'],
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => true,
                'attr' => ['class' => 'container', 'required' => false]
            ])
            ->add('musicfileplproject', CollectionType::class, ['entry_type' => MusicFileType::class,
                'entry_options' => ['label' => 'Add some musics for your project'],
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => true,
                'attr' => ['class' => 'container', 'required' => false]
            ])
            ->add('save', SubmitType::class, ['label' => 'SUBMIT MY PROJECT',
                'attr' => ['class' => 'save']]);

    }

}
