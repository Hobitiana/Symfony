<?php

namespace App\Form;

use App\Entity\GroupeActivite1;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class GroupeActivite1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', EntityType::class, [ // Changed 'nomGroupe' to 'nom' to match the entity field
                'class' => GroupeActivite1::class, 
                        'choice_label' => 'nom', // Ce qui sera affiché dans la liste déroulante
                        'label' => 'Groupe activité',
                        'required' => true, // Champ obligatoire      
                
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GroupeActivite1::class,
        ]);
    }
}
