<?php

namespace App\Form;


use App\Entity\Commune;
use App\Entity\District;
use App\Entity\Fokotany;
use App\Entity\LieuImplantation;
use App\Entity\Region;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuImplantationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('region', EntityType::class, [
                'class' => Region::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez une région',
            ])
            ->add('district', EntityType::class, [
                'class' => District::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez un district',
                'choices' => [], // Empty initially
            ])
            ->add('commune', EntityType::class, [
                'class' => Commune::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez une commune',
                'choices' => [], // Empty initially
            ])
            ->add('fokotany', EntityType::class, [
                'class' => Fokotany::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez un fokotany',
                'choices' => [], // Empty initially
            ])
            ->add('adresse', TextType::class, [
                'attr' => ['class' => 'form-control']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LieuImplantation::class,
        ]);
    }
}
