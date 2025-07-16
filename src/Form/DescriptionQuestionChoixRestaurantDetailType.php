<?php

namespace App\Form;

use App\Entity\DescriptionQuestionChoixRestaurant;
use App\Entity\DescriptionQuestionChoixRestaurantDetail;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DescriptionQuestionChoixRestaurantDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reponse', CheckboxType::class, [
                'label' => 'reponse',
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DescriptionQuestionChoixRestaurantDetail::class,
        ]);
    }
}
