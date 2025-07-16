<?php

namespace App\Form;

use App\Entity\DesignationReference;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ReferenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference', TextType::class, [
                'label' => 'Entrez la référence',
                'required' => true,
            ])
            ->add('datesignature', null, [
                'widget' => 'single_text'
            ])
            ->add('signataire', TextType::class, [
                'label' => 'Entrez le signataire',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DesignationReference::class,
        ]);
    }
}
