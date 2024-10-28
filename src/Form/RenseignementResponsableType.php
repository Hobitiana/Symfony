<?php

namespace App\Form;

use App\Entity\RenseignementResponsable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RenseignementResponsableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('responsable', ChoiceType::class, [
            'choices' => [
                "Gérant" => 'Gérant',
                "Directeur général" => "Directeur général",
                "Surveillant général" => "Surveillant général",
            ],

        ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RenseignementResponsable::class,
        ]);
    }
}
