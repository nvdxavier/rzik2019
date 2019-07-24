<?php

namespace App\Form;

use App\Entity\MusicFile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Doctrine\Common\Persistence\ObjectManager;

class MusicFileType extends AbstractType
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
            ->add('filename', FileType::class, ['label' => 'your music creation', 'data_class' => null]);
//            ->add('filetitle',TextType::class,['label' => 'Title'])
//            ->add('filedescription', TextareaType::class,['label' => 'Description']);
//            ->add('filedate')
//            ->add('fileartist')
//            ->add('filecomposer')
//            ->add('filecategory')
//            ->add('fileposition')
//            ->add('fileduration')
//            ->add('filetransfertdate')
//            ->add('playlist')


//        $builder->add('save', SubmitType::class, [
//            'attr' => ['class' => 'save'],
//        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MusicFile::class,
            'csrf_protection' => true
        ]);
    }
}
