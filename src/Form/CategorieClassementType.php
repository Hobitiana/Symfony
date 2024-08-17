<?php

namespace App\Form;

use App\Entity\CategorieClassement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieClassementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ravinalaSelection', ChoiceType::class, [
                'choices' => [
                    'Ravinala 1' => 'Ravinala 1',
                    'Ravinala 2' => 'Ravinala 2',
                    'Ravinala 3' => 'Ravinala 3',
                ],
                'label' => 'Sélectionnez Ravinala',
                'required' => true,
            ])
            ->add('etoileSelection', ChoiceType::class, [
                'choices' => [
                    'Étoile 1' => 'Étoile 1',
                    'Étoile 2' => 'Étoile 2',
                    'Étoile 3' => 'Étoile 3',
                ],
                'label' => 'Sélectionnez Étoile',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategorieClassement::class,
        ]);
    }
}
