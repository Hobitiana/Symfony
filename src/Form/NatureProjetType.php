<?php

namespace App\Form;

use App\Entity\NatureProjet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NatureProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
            ->add('nature', ChoiceType::class, [
                'choices' => [
                    "Amenagement" => 'Amenagement',
                    "Nouvelle construction" => "Nouvelle construction",
                    "Extension" => "Extension",
                ],

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NatureProjet::class,
        ]);
    }
}
