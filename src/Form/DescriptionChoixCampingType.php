<?php

namespace App\Form;

use App\Entity\DescriptionQuestionChoixCamping;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DescriptionChoixCampingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('details', CollectionType::class, [
                'entry_type' => DescriptionQuestionChoixCampingDetailType::class,
                'entry_options' => [
                    'label' => false,
                    'required' => false, // Permet les champs vides
                ],
                'allow_add' => true,
                'by_reference' => false,
                'label' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DescriptionQuestionChoixCamping::class,
        ]);
    }
}
