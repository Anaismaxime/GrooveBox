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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class PostsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', options: [
                'label' => 'Titre',
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Contenu',
                'required' => true,
                'attr' => [
                    'class' => 'form-control ckeditor'
                ]
            ])
            ->add('coverImage', FileType::class, [
                'label' => 'Image de Couverture',
                'mapped' => false,
                'constraints' => [
                    new Image (
                        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
                        mimeTypesMessage: 'Seuls les formats JPG, PNG et WEBP sont acceptés'
                    )
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
                'expanded' => true,
                'label' => 'Artistes associés à cet article',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Posts::class,
        ]);
    }
}
