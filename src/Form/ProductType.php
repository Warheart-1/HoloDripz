<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;



class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'attr' => [
                    'placeholder' => 'Enter product name',
                    'id' => 'product_name',
                    'class' => 'form-control',
                ],
            ])
            ->add('excerpt', TextType::class, [
                'label' => 'Excerpt',
                'attr' => [
                    'placeholder' => 'Enter product excerpt',
                    'id' => 'product_excerpt',
                    'class' => 'form-control',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Enter product description',
                    'id' => 'product_description',
                    'class' => 'form-control',
                ],
            ])
            ->add('quantity', IntegerType::class, [
                'label' => 'Quantity',
                'attr' => [
                    'placeholder' => 'Enter product quantity',
                    'id' => 'product_quantity',
                    'class' => 'form-control',
                ],
            ])
            ->add('image', FileType::class, [
                'label' => 'Image',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Enter product image',
                    'id' => 'product_image',
                    'class' => 'form-control',
                ],
            ])
            ->add('category', EntityType::class, [
                'label' => 'Category',
                'attr' => [
                    'placeholder' => 'Enter product category',
                    'id' => 'product_category',
                    'class' => 'form-control',
                ],
                'class' => 'App\Entity\Category',
                'choice_label' => 'name',
            ])
            ->add('subcategory', EntityType::class, [
                'label' => 'Subcategory',
                'attr' => [
                    'placeholder' => 'Enter product subcategory',
                    'id' => 'product_subcategory',
                    'class' => 'form-control',
                ],
                'class' => 'App\Entity\Subcategory',
                'choice_label' => 'name',
            ])
            ->add('price', NumberType::class, [
                'label' => 'Price',
                'attr' => [
                    'placeholder' => 'Enter product price',
                    'id' => 'product_price',
                    'class' => 'form-control',
                ],
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Status',
                'attr' => [
                    'placeholder' => 'Enter product status',
                    'id' => 'product_status',
                    'class' => 'form-control',
                ],
                'choices' => [
                    'Active' => 0,
                    'Inactive' => 1,
                    'Sold' => 3,
                ],
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
