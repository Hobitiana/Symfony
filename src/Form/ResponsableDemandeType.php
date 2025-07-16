<?php

namespace App\Form;

use App\Entity\MaDemande;
use App\Entity\ResponsableDemande;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResponsableDemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('DRTM')
            ->add('EDBM')
            ->add('DAT')
            ->add('DG')
            ->add('SG')
            ->add('Ministre')
            ->add('MaDemande', EntityType::class, [
                'class' => MaDemande::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ResponsableDemande::class,
        ]);
    }
}
