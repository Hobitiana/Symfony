<?php

namespace App\Form;

use App\Entity\ActiviteRestaurant;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActiviteRestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('activite', ChoiceType::class, [
            'choices' => [                       
                "Restaurant" => "Restaurant",
                "Bar" => "Bar",
                "Autre" => "Autre",
            ],
            'label' => 'Sélectionnez votre  Activite :',
            'required' => true,
        ])
      ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ActiviteRestaurant::class,
        ]);
    }
}
