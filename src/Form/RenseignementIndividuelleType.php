<?php

namespace App\Form;

use App\Entity\RenseignementIndividuelle;
use App\Entity\Nationalite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RenseignementIndividuelleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('individuNom', TextType::class, [
            'label' => 'Nom',
            'required' => true, // Champ obligatoire
            'attr' => [
                'placeholder' => 'Entrez votre nom',
            ],
        ])
        ->add('individuPrenom', TextType::class, [
            'label' => 'Prénom',
            'required' => true, // Champ obligatoire
            'attr' => [
                'placeholder' => 'Entrez votre prénom',
            ],
        ])
        ->add('adresseIndividu', TextType::class, [
            'label' => 'Adresse',
            'required' => true, // Champ obligatoire
            'attr' => [
                'placeholder' => 'Entrez votre adresse',
            ],
        ])
        ->add('mailIndividu', EmailType::class, [
            'label' => 'Email',
            'required' => true, // Validation côté client et serveur pour email
            'attr' => [
                'placeholder' => 'Entrez votre adresse email',
            ],
        ])
        ->add('phoneIndividu', TelType::class, [
            'label' => 'Téléphone',
            'required' => true,
            'attr' => [
                'placeholder' => 'Entrez votre numéro de téléphone'
            ],
            'constraints' => [
                new Length([
                    'min' => 10,
                    'max' => 20,
                    'exactMessage' => 'Le numéro de téléphone doit comporter exactement {{ limit }} chiffres.',
                ]),
                new Regex([
                    'pattern' => '/^\d+$/',
                    'message' => 'Le numéro de téléphone ne doit contenir que des chiffres.',
                ]),
            ],
            ])
            ->add('nationalite', EntityType::class, [
                'class' => Nationalite::class, 
                        'choice_label' => 'nomNationalite', // Ce qui sera affiché dans la liste déroulante
                        'label' => 'Nationalite',
                        'required' => true, // Champ obligatoire      
                
            ]);
           
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RenseignementIndividuelle::class,
        ]);
    }
}
