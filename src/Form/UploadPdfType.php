<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;  // Importer la contrainte File pour la validation

class UploadPdfType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('pdfFile', FileType::class, [
            'label' => 'Upload PDF',
            'required' => true,
            'constraints' => [
                new File([
                    'maxSize' => '10M',  // Limite la taille du fichier à 10 Mo
                    'mimeTypes' => [
                        'application/pdf',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid PDF document',
                ]),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configurer les options du formulaire ici
        ]);
    }
}
