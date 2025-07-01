<?php

namespace App\Form;

use App\Entity\Artists;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class ArtistsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextareaType::class, [
                'label' => 'Nom de l\'Artiste',
            ])
            ->add('biography', TextareaType::class, [
                'label' => 'Biographie',
            ])
            ->add('country', options: [
                'label' => 'Pays',
            ])
            ->add('urlSoundcloud', UrlType::class, [
                'label' => 'Url Soundcloud',
                'required' => false,
            ])
            ->add('urlSpotify', UrlType::class, [
                'label' => 'Url Spotify',
                'required' => false,
            ])
            ->add('picture',  FileType::class, [
                'label' => 'Photo de l\'Artiste',
                'mapped' => false,
                'constraints' => [
                    new Image(
                        mimeTypes: ['image/png', 'image/jpg', 'image/jpeg', 'image/webp'],
                        mimeTypesMessage: 'Seules les formats  suivantes: png, jpg, jpeg, webp sont autorisés',
                    )
                ]
            ])
            ->add('artistOfTheWeek',  checkboxType::class, [
                'label' => 'Artiste de la semaine',
            ])
            ->add('Submit',  SubmitType::class, [
                'label'=> 'Ajouter'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artists::class,
        ]);
    }
}
