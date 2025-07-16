<?php
namespace App\Form;

use App\Entity\Activite1;
use App\Entity\GroupeActivite1;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class Activite1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [ // 'null' est le type de champ par défaut
                'label' => 'Nom de l\'activité',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Entrez le nom de l\'activité',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le nom ne peut pas être vide.',
                    ]),
                    new Assert\Length([
                        'min' => 3,
                        'minMessage' => 'Le nom doit comporter au moins {{ limit }} caractères.',
                        'max' => 255,
                        'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ],
            ])
            ->add('idGroupeActivite1', EntityType::class, [
                'class' => GroupeActivite1::class,
                'choice_label' => 'id', // Remplacez 'id' par une propriété plus descriptive si nécessaire, comme 'nom'.
                'label' => 'Groupe d\'Activité',
                'required' => true,
                'placeholder' => 'Sélectionnez un groupe',
                'attr' => [
                    'class' => 'form-select',
                ],
                'constraints' => [
                    new Assert\NotNull([
                        'message' => 'Veuillez sélectionner un groupe d\'activité.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activite1::class,
        ]);
    }
}
