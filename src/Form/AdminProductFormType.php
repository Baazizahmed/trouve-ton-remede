<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AdminProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du produit',
            ])
            ->add('slug', TextType::class, [
                'label' => 'Slug',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'rows' => 5,
                ],
            ])
            ->add('benefits', TextareaType::class, [
                'label' => 'Bienfaits',
                'required' => false,
                'attr' => [
                    'rows' => 4,
                    'placeholder' => 'Ex : apaise les maux de tête, favorise le sommeil…',
                ],
            ])
            ->add('usage', TextareaType::class, [
                'label' => 'Utilisation',
                'required' => false,
                'attr' => [
                    'rows' => 4,
                    'placeholder' => 'Ex : 1 à 2 tasses par jour, à consommer le soir…',
                ],
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix',
                'currency' => false, // tu gères le symbole dans le template
                'scale' => 2,
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'label' => 'Image du produit',
                'download_uri' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
