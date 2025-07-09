<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;


class AvatarForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('avatar', FileType::class, [
                'label' => 'Nouvel Avatar',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new Image(
                        mimeTypes: ['image/png', 'image/jpg', 'image/jpeg', 'image/webp'],
                        mimeTypesMessage: 'Le fichier n\'est pas une image'
                    )
                ]
            ])
            ->add('submit', SubmitType::class )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            //Non lié à une entité
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'upload_avatar',
        ]);
    }
}
