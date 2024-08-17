<?php

namespace App\Form;

use App\Entity\TypeActivite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeActiviteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('natureActivite', ChoiceType::class, [
            'choices' => [
                "Motel" => "Motel",
                "Hotel" => "Hotel",
                "Restaurant" => "Restaurant",
                "Agence de Voyage" => "Agence de Voyage",
                "Location" => "Location",
                "Snack ou cafe" => "Snack ou cafe",
                "Autre" => "Autre",
            ],
            'multiple' => true,  // Allow multiple choices
            'expanded' => true,  // Use checkboxes instead of a dropdown
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TypeActivite::class,
        ]);
    }
}
