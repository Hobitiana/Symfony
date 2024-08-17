<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password',
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('prenoms', TextType::class, [
                'label' => 'Prénoms',
            ])
            ->add('entreprise', ChoiceType::class, [
                'label' => 'Entreprise',
                'choices' => [
                    'Entreprise A' => 'entreprise_a',
                    'Entreprise B' => 'entreprise_b',
                    'Entreprise C' => 'entreprise_c',
                ],
                'required' => false,
            ])
            ->add('responsable', ChoiceType::class, [
                'label' => 'Responsable',
                'choices' => [
                    'Responsable A' => 'responsable_a',
                    'Responsable B' => 'responsable_b',
                    'Responsable C' => 'responsable_c',
                ],
                'required' => false,
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse',
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone',
            ])
            ->add('image', TextType::class, [
                'label' => 'Image',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
