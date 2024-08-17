<?php

namespace App\Form;

use App\Entity\RenseignementIndividuelle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RenseignementIndividuelleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('individuNom')
            ->add('individuPrenom')
            ->add('adresseIndividu')
            ->add('mailIndividu')
            ->add('phoneIndividu')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RenseignementIndividuelle::class,
        ]);
    }
}
