<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ActiviteHotelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('activite', ChoiceType::class, [
                'choices' => $options['activite_choices'], // Utiliser les choix passés depuis le contrôleur
                'label' => 'Sélectionnez votre Activite :',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Autres options par défaut ici...
        ]);

        // On s'attend à recevoir les choix d'activités depuis les options
        $resolver->setRequired('activite_choices');
    }
}
