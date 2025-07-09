<?php

namespace App\Form;

use App\Entity\Genres;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class GenresForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du genre',
                'attr' => [
                    'placeholder' => 'Ex : House, Techno, Ambient...',
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom du genre est obligatoire.',
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Le genre doit contenir au moins {{ limit }} caractères.',
                        'max' => 100,
                        'maxMessage' => 'Le genre est trop long ({{ limit }} caractères max).',
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Genres::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'genres_form',
        ]);
    }
}
