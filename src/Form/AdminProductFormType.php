<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
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
            ->add('description', null, [
                'label' => 'Description',
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix',
                'currency' => false, // On gère l'affichage du symbole monétaire dans le template
                'scale' => 2, // Nombre de décimales
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
