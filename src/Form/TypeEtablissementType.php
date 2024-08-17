<?php

namespace App\Form;


use App\Entity\TypeEtablissement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeEtablissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nature', ChoiceType::class, [
                'choices' => [
                    "Hotel_Restaurant" => 'Hotel_Restaurant',
                    "Hotel" => "Hotel",
                    "Restaurant" => "Restaurant",
                    "Terrain Camping" => "Terrain Camping",
                    "A" => "A",
                    "B" => "B",
                    "C" => "C",
                ],
                'multiple' => true,  // Allow multiple choices
                'expanded' => true,  // Use checkboxes instead of a dropdown
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TypeEtablissement::class,
        ]);
    }
}
