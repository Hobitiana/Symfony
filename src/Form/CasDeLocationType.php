<?php

namespace App\Form;

use App\Entity\CasDeLocation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CasDeLocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomBailleur', TextType::class, [
                'label' => 'Nom du Bailleur',
                'required' => true,
            ])
            ->add('adresseBailleur', TextType::class, [
                'label' => 'Adresse du Bailleur',
                'required' => true,
            ])
            ->add('nomPreneur', TextType::class, [
                'label' => 'Nom du Preneur',
                'required' => true,
            ])
            ->add('adresseDePreneur', TextType::class, [
                'label' => 'Adresse du Preneur',
                'required' => true,
            ])
            ->add('dureeBailleur', IntegerType::class, [
                'label' => 'Durée du Bailleur',
                'required' => true,
            ])
            ->add('dateDebut', DateType::class, [
                'label' => 'Date de Début',
                'widget' => 'single_text',
                'required' => true,
            ])
            ->add('dateFin', DateType::class, [
                'label' => 'Date de Fin',
                'widget' => 'single_text',
                'required' => true,
            ])
            ->add('nomDuSignateur', TextType::class, [
                'label' => 'Nom du Signateur',
                'required' => true,
            ])
            ->add('dateDuSignateur', DateType::class, [
                'label' => 'Date du Signateur',
                'widget' => 'single_text',
                'required' => true,
            ])
            ->add('signataire', TextType::class, [
                'label' => 'Signataire',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CasDeLocation::class,
        ]);
    }
}
