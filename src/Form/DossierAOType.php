<?php

namespace App\Form;

use App\Entity\DossierAO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class DossierAOType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lettreDemande', FileType::class, [
                'label' => 'Lettre de demande (PDF, DOCX, etc.)',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        ],
                        'mimeTypesMessage' => 'Veuillez téléverser un fichier valide (PDF ou Word)',
                    ])
                ],
            ])
            ->add('cnaps', FileType::class, [
                'label' => 'CNAPS (Image ou fichier)',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'application/pdf',
                        ],
                        'mimeTypesMessage' => 'Veuillez téléverser une image ou un fichier PDF valide',
                    ])
                ],
            ])
            ->add('copieVisaCertifie', FileType::class, [
                'label' => 'Copie Visa Certifiée (Image ou PDF)',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'application/pdf',
                        ],
                        'mimeTypesMessage' => 'Veuillez téléverser une image ou un fichier PDF valide',
                    ])
                ],
            ])
            ->add('attestationAssurance', FileType::class, [
                'label' => 'Attestation d\'assurance (PDF ou image)',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'application/pdf',
                        ],
                        'mimeTypesMessage' => 'Veuillez téléverser une image ou un fichier PDF valide',
                    ])
                ],
            ])
            ->add('attestationFinanciere', FileType::class, [
                'label' => 'Attestation financière (PDF ou image)',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'application/pdf',
                        ],
                        'mimeTypesMessage' => 'Veuillez téléverser une image ou un fichier PDF valide',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DossierAO::class,
        ]);
    }
}
