<?php

namespace App\Form;

use App\Entity\CasDeLocation;
use App\Entity\CategorieClassement;
use App\Entity\Environnement;
use App\Entity\LieuImplantation;
use App\Entity\MaDemande;
use App\Entity\NatureOuvrage;
use App\Entity\NatureProjet;
use App\Entity\PlanMasse;
use App\Entity\RelationActivite;
use App\Entity\RenseignementCIN;
use App\Entity\RenseignementEntreprise;
use App\Entity\RenseignementIndividuelle;
use App\Entity\RenseignementTypeEntreprise;
use App\Entity\RenseignementVisa;
use App\Entity\TypeConstruction;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaDemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateActuel', null, [
                'widget' => 'single_text',
            ])
            ->add('maTypeDeDemande')
            ->add('status')
            ->add('idCasDeLocation', EntityType::class, [
                'class' => CasDeLocation::class,
                'choice_label' => 'id',
            ])
            ->add('idCategorieClassement', EntityType::class, [
                'class' => CategorieClassement::class,
                'choice_label' => 'id',
            ])
            ->add('idLieuImplantation', EntityType::class, [
                'class' => LieuImplantation::class,
                'choice_label' => 'id',
            ])
            ->add('idNatureOuvrage', EntityType::class, [
                'class' => NatureOuvrage::class,
                'choice_label' => 'id',
            ])
            ->add('idNatureProjet', EntityType::class, [
                'class' => NatureProjet::class,
                'choice_label' => 'id',
            ])
            ->add('idPlanMasse', EntityType::class, [
                'class' => PlanMasse::class,
                'choice_label' => 'id',
            ])
            ->add('idRelationActivite', EntityType::class, [
                'class' => RelationActivite::class,
                'choice_label' => 'id',
            ])
            ->add('idUsers', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('idRenseignementEntreprise', EntityType::class, [
                'class' => RenseignementTypeEntreprise::class,
                'choice_label' => 'id',
            ])
            ->add('idRenseignementEntreprises', EntityType::class, [
                'class' => RenseignementEntreprise::class,
                'choice_label' => 'id',
            ])
            ->add('idResneignementIndividuelle', EntityType::class, [
                'class' => RenseignementIndividuelle::class,
                'choice_label' => 'id',
            ])
            ->add('idRenseignementCIN', EntityType::class, [
                'class' => RenseignementCIN::class,
                'choice_label' => 'id',
            ])
            ->add('idRenseignementVisa', EntityType::class, [
                'class' => RenseignementVisa::class,
                'choice_label' => 'id',
            ])
            ->add('idEnvironnement', EntityType::class, [
                'class' => Environnement::class,
                'choice_label' => 'id',
            ])
            ->add('idTypeConstruction', EntityType::class, [
                'class' => TypeConstruction::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MaDemande::class,
        ]);
    }
}
