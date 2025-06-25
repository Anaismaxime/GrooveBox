<?php

namespace App\Form;

use App\Entity\Posts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
                'label'  => 'Titre',
            ])
            ->add('content', TextareaType::class, [
                'label'  => 'Contenu',
            ])
            ->add('coverImage', FileType::class, [
                'label' => 'Image de Couverture',
                'mapped' => false,
                'constraints' => [
                    new Image (
                        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
                        mimeTypesMessage : 'Seuls les formats JPG, PNG et WEBP sont acceptés'
                    )
                ]
            ])
            ->add('type', ChoiceType::class, [
                'label'  => 'Type de Contenu',
                'choices' => [
                    '' => '',
                    'Culture' => 'cultural',
                    'Actualité' => 'news',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label'  => 'Envoyer',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Posts::class,
        ]);
    }
}
