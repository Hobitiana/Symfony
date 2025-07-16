<?php

namespace App\Form;

use App\Entity\DescriptionHebergement;
use App\Entity\DescriptionHebergementDetail;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DescriptionHebergementDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', IntegerType::class, [
                'label' => 'nombre',
                'attr' => [
                    'min' => 0, // No negative numbers
                ],
            ])
            ->add('superficie', IntegerType::class, [
                'label' => 'superficie',
                'attr' => [
                    'min' => 0, // No negative numbers
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DescriptionHebergementDetail::class,
        ]);
    }
}
