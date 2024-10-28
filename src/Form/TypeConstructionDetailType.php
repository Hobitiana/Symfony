<?php
namespace App\Form;

use App\Entity\TypeConstructionDetail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeConstructionDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('unite', IntegerType::class, [
                'label' => 'Unité',
                'attr' => [
                    'min' => 0, // No negative numbers
                ],
            ])
            ->add('nombre', IntegerType::class, [
                'label' => 'Nombre',
                'attr' => [
                    'min' => 0, // No negative numbers
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TypeConstructionDetail::class,
        ]);
    }
}

