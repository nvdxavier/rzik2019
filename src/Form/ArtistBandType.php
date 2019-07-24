<?php

namespace App\Form;

use App\Entity\ArtistBand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ArtistBandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('artistbandname', TextType::class)
            ->add('artistbanddescription', TextareaType::class)
            ->add('artistbanddateceation', DateType::class)
            ->add('artistbandfacebook', UrlType::class)
            ->add('artistbandinstagram', UrlType::class)
            ->add('artistbandtwitter', UrlType::class)
            ->add('artistbandlogo', CollectionType::class, [
                'entry_type' => PictureType::class,
                'entry_options' => ['label' => true],
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
                'attr' => ['class' => 'container',
                    'required' => false]
            ])
            ->add('artistbandcountry', CountryType::class)
            ->add('artistbandcity', TextType::class)
            ->add('artistbandcategory', TextType::class)
            ->add('artistbandpicture', CollectionType::class, [
                'entry_type' => PictureType::class,
                'entry_options' => ['label' => true],
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
                'attr' => ['class' => 'container',
                    'required' => false]
            ]);

        $builder->add('save', SubmitType::class, [
            'attr' => ['class' => 'save'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ArtistBand::class,
            'error_mapping' => [
                'matchingCityAndZipCode' => 'city',
            ],
        ]);
    }
}
