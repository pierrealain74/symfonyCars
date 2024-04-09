<?php

namespace App\Form;

use App\Entity\Cars;
use App\Entity\Brand;
use App\Entity\Color;
use App\Entity\Energy;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CarsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '255'
                ],
                'label' => 'Titre de l\'annonce',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 255]),
                    new Assert\NotBlank()

                ]
            ])
            ->add('power', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Puissance (ch)',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Positive()
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Description',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])

            ->add('price', MoneyType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Prix',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Positive(),
                    new Assert\LessThan(10500000)

                ]
            ])
            ->add('energy', EntityType::class, [
                'attr' => [
                    'class' => 'form-select',
                ],
                'class' => Energy::class,
                'choice_label' => 'name',
                'label' => 'Energie',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])
            ->add('nb_door', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Nombre de portes',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Positive(),
                ]
            ])
            ->add('ct', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input mt-4',
                ],
                'label' => 'Contrôle technique',
                'required' => false,
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ],
            ])
            ->add('adress_product', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Adresse où se trouve le bien',
                'required' => true,
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])
            ->add('color', EntityType::class, [
                'attr' => [
                    'class' => 'form-select',
                ],
                'class' => Color::class,
                'choice_label' => 'name',
                'label' => 'Couleur',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])

            ->add('brand', EntityType::class, [
                'attr' => [
                    'class' => 'form-select',
                ],
                'class' => Brand::class,
                'choice_label' => 'name',
                'label' => 'Marque',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])
            ->add('images', FileType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'multiple' => true,
                'mapped' => false,
                'required' => false,

                'constraints' => [
                    new All([
                        'constraints' => [
                            new File([
                                'maxSize' => '3M',
                                'mimeTypes' => [
                                    'image/jpeg',
                                    'image/png',
                                    'image/gif',
                                ],
                                'mimeTypesMessage' => 'Veuillez télécharger une image valide (jpg, jpeg, png, gif)',
                            ]),
                        ],
                    ]),
                ],

            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary  mt-4',
                ],
                'label' => 'OK',
            ]);

        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cars::class,
        ]);
    }
}
