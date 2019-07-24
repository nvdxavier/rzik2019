<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Tag;
use Doctrine\ORM\EntityRepository;

class TagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tagname', TextType::class, ['label' => 'Catégorie']);

//        $builder->add('tags', EntityType::class, [
//            'class' => Tag::class,
//            'query_builder' => function (EntityRepository $er) {
//                return $er->createQueryBuilder('t')
//                    ->orderBy('t.tagname', 'ASC');
//            },
//            'choice_label' => 'tagname',
//        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tag::class,
        ]);
    }
}