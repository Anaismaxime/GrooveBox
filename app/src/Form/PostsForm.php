<?php

namespace App\Form;

use App\Entity\Artists;
use App\Entity\Genres;
use App\Entity\Posts;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PostsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le titre est obligatoire.'
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Le titre doit contenir au moins {{ limit }} caractères.',
                        'max' => 255,
                        'maxMessage' => 'Le titre est trop long ({{ limit }} caractères max).'
                    ])
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Contenu',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le contenu de l\'article ne peut pas être vide.'
                    ]),
                    new Length([
                        'min' => 50,
                        'minMessage' => 'Le contenu doit faire au moins {{ limit }} caractères.'
                    ])
                ],
                'attr' => [
                    'class' => 'form-control ckeditor'
                ]
            ])
            ->add('coverImage', FileType::class, [
                'label' => 'Image de Couverture',
                'mapped' => false,
                'required' => false, // utile si tu ne veux pas forcer l'image à chaque édition
                'constraints' => [
                    new Image([
                        'maxSize' => '2M',
                        'maxSizeMessage' => 'L\'image ne peut pas dépasser 2 Mo.',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/webp'],
                        'mimeTypesMessage' => 'Seuls les formats JPG, PNG et WEBP sont acceptés.'
                    ])
                ]
            ])
            ->add('genre', EntityType::class, [
                'class' => Genres::class,
                'label' => 'Genre',
                'choice_label' => 'name',
                'placeholder' => 'Choisissez un genre',
                'required' => true,
            ])
            ->add('artists', EntityType::class, [
                'class' => Artists::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false, // ⚠️ très important pour que ce soit un <select>
                'label' => 'Artistes associés à cet article',
                'attr' => [
                    'class' => 'form-select',
                ],
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Publier l’article',
                'attr' => ['class' => 'btn-black']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Posts::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'posts_form',
        ]);
    }
}
