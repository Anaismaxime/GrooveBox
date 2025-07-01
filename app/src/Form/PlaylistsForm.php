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

class PlaylistsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('spotifyId', TextType::class, [
                'label' => 'Spotify ID',
            ])
            ->add('isPublic', CheckboxType::class, [
                'label' => 'Rendre Public?',
            ])
            ->add('genre', EntityType::class, [
                'label'  => 'Genre',
                'class' => Genres::class,
                'choice_label' => 'name',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Playlists::class,
        ]);
    }
}
