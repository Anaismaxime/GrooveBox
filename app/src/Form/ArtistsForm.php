<?php

namespace App\Form;

use App\Entity\Artists;
use App\Entity\Genres;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ArtistsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextareaType::class, [
                'label' => 'Nom de l\'Artiste',
                'constraints' => [
                    new NotBlank(
                        message:'Le nom de l\'artiste est obligatoire'
                    ),
                    new Length([
                        'min' => 3,
                        'max' => 100,
                        'minMessage' => 'Le nom de l\'artiste doit faire au moins 3 caractères',
                        'maxMessage' => 'Le nom de l\'artiste doit faire moins de 100 caractères'
                    ])
                ]
            ])
            ->add('biography', TextareaType::class, [
                'label' => 'Biographie',
                'required' => true,
                'attr' => [
                    'class' =>  'form-control ckeditor'
                ]
            ])
            ->add('country', TextType::class, [
                'label' => 'Pays',
                'required' => true,
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
            ->add('genre', EntityType::class, [
                'class' => Genres::class,
                'label'  => 'Genre',
                'choice_label' => 'name',
                'placeholder' => 'Choisissez un genre',
                'required' => true,
            ])
            ->add('artistOfTheWeek',  checkboxType::class, [
                'label' => 'Artiste de la semaine',
                'required' => false
            ])
            ->add('submit',  SubmitType::class, [
                'label'=> 'Ajouter'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artists::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'artists_item',
        ]);
    }
}
