<?php

namespace App\Form;

use App\Entity\NatureOuvrage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NatureOuvrageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
            ->add('nature', ChoiceType::class, [
                'choices' => [
                    "En dur" => 'En dur',
                    "En Materiaux Locaux" => "En Materiaux Locaux",
                    "En semi dur" => "En semi dur",
                    "Autre" => "Autre",
                ],

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NatureOuvrage::class,
        ]);
    }
}
