<?php

namespace App\Form;

use App\Entity\RenseignementEntreprise;

use App\Entity\Nationalite;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RenseignementEntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('denominationSociale')
            ->add('enseigneCommerciale')
            ->add('adresseEntreprise')
            ->add('registreCommerce')
            ->add('nomMandataire')
            ->add('prenomMandataire')
            ->add('nationalite', EntityType::class, [
                'class' => Nationalite::class, 
                        'choice_label' => 'nomNationalite', // Ce qui sera affiché dans la liste déroulante
                        'label' => 'Nationalite',
                        'required' => true, // Champ obligatoire      
            ])
            ->add('telephoneEntreprise')
            ->add('mailEntreprise')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RenseignementEntreprise::class,
        ]);
    }
}
