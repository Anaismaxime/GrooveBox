<?php

namespace App\Form;

use App\Entity\Comments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class CommentsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class,  [
                'label' => 'Ton commentaire',
                'attr' => [
                    'rows' => 4,
                    'placeholder' => 'Exprime toi!'], //Row pour hauteur du champs commentaire
                'constraints' => [
                    new NotBlank(
                        ['message' => 'Le commentaire ne peut pas être vide.']
                    ),
                    new Length([
                        'min' => 5,
                        'max' => 255,
                        'minMessage' => 'Le commentaire dois contenir au moins 5 caractères ',
                        'maxMessage' => 'Le commentaire ne peut pas dépasser 255 caractères',
                    ])
                ]
            ])
            ->add('submit', SubmitType::class,  [
                'label' => 'Enregistrer',
    ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'comments_form',
        ]);
    }
}
