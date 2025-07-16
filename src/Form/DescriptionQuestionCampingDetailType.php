<?php

namespace App\Form;

use App\Entity\DescriptionQuestionCampingDetail;
use App\Entity\DescriptionQuestionRestaurant;
use App\Entity\DescriptionQuestionRestaurantDetail;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DescriptionQuestionCampingDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reponse', TypeTextType::class, [
                'label' => 'reponse',
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DescriptionQuestionCampingDetail::class,
        ]);
    }
}
