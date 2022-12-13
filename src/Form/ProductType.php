<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('excerpt')
            ->add('description')
            ->add('quantity')
            ->add('image')
            ->add('price')
            ->add('status')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('sold')
            ->add('seller')
            ->add('isFavorite')
            ->add('category')
            ->add('subCategory')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
