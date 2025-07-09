<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => [
                    new NotBlank(
                        message: 'L\'email est obligatoire.',
                    ),
                    new Email(
                        message:'Veuillez entrer une adresse email valide.',
                    )
                ]
            ])
            ->add('subject', TextareaType::class, [
                'label' => 'Message',
                'constraints' => [
                    new NotBlank(
                        message: 'Le message ne peut pas être vide.',
                    ),
                    new Length(
                        min: 10,
                        minMessage:'Le message doit contenir au moins {{ limit }} caractères.',
                        max: 1000,
                        maxMessage:'Le message est trop long (maximum {{ limit }} caractères).',
                    ),
                ],
                'attr' => [
                    'placeholder' => 'Entrez votre message',
                ]
            ])
            ->add('agreeterms', CheckboxType::class, [
                'label' => 'J\'accepte la collecte de mes données personnelles par La Groove Box dans le cadre de ce formulaire',
                'mapped' => false,
                'constraints' => [
                    new IsTrue(
                        message: 'Vous devez accepter les conditions d\'utilisation.',
                    ),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'contact_form_token',
        ]);
    }
}
