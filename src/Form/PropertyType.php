<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('description', TextareaType::class, ['label' => 'Description', 'required' => false])
            ->add('surface', IntegerType::class, ['label' => 'Surface (m²)'])
            ->add('rooms', IntegerType::class, ['label' => 'Pièces'])
            ->add('bedrooms', IntegerType::class, ['label' => 'Chambres'])
            ->add('floor', IntegerType::class, ['label' => 'Étage'])
            ->add('price', IntegerType::class, ['label' => 'Prix'])
            ->add('heat', ChoiceType::class, [
                'label' => 'Chauffage',
                'choices' => [
                    'Électrique' => 0,
                    'Gaz' => 1,
                ]
            ])
            ->add('city', TextType::class, ['label' => 'Ville'])
            ->add('address', TextType::class, ['label' => 'Adresse'])
            ->add('no', TextType::class, ['label' => 'Numéro', 'required' => false])
            ->add('sold', CheckboxType::class, ['label' => 'Vendu', 'required' => false])
            ->add('lat', TextType::class, ['label' => 'Latitude', 'required' => false])
            ->add('lng', TextType::class, ['label' => 'Longitude', 'required' => false])
            ->add('pictureFiles', FileType::class, [
                'label' => 'Images',
                'multiple' => true,
                'required' => false,
                'mapped' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
