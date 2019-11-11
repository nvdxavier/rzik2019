<?php

namespace App\Form;

use App\Entity\Picture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class PictureType extends AbstractType
{

    /**
     * @var ObjectManager
     */
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('picturefile', FileType::class, [
//                'label' => 'add a picture',
//                                                             'data_class' => null,
//                                                             'by_reference' => false,
//                                                             'multiple' =>true,
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Picture::class,
            'csrf_protection' => true
        ]);
    }
}
