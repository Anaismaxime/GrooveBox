<?php

namespace App\Form;

use App\Entity\Genres;
use App\Entity\Playlists;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PlaylistsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('spotifyId', TextType::class, [
                'label' => 'Spotify ID',
                'attr' => [
                    'placeholder' => 'Copiez l’ID ou l’URL de la playlist',
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'L\'identifiant Spotify est obligatoire.',
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'L’ID est trop court.',
                        'max' => 100,
                        'maxMessage' => 'L’ID est trop long.',
                    ])
                ]
            ])
            ->add('isPublic', CheckboxType::class, [
                'label' => 'Rendre Public ?',
                'required' => false
            ])
            ->add('genre', EntityType::class, [
                'label'  => 'Genre associé',
                'class' => Genres::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez un genre',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn-black'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Playlists::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'playlist_form',
        ]);
    }
}
