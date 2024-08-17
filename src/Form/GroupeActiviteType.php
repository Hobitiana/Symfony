<?php

namespace App\Form;

use App\Entity\GroupeActivite;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupeActiviteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('activite', ChoiceType::class, [
            'choices' => [
                "Motel" => "Motel",
                "Hotel" => "Hotel",
                "Restaurant" => "Restaurant",
                "Agence de Voyage" => "Agence de Voyage",
                "Camping" => "Camping",
                "Autre" => "Autre",
            ],
            'label' => 'Sélectionnez votre Groupe Activite :',
            'required' => true,
        ])
    ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GroupeActivite::class,
        ]);
    }
}
