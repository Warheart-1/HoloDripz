<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\User;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;



class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Email',
                ],
            ])
            ->add('name', TextType::class, [
                'label' => 'Name',
                'attr' => [
                    'placeholder' => 'Name',
                ],
                
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Lastname',
                'attr' => [
                    'placeholder' => 'Lastname',
                ],
            ])
            ->add('phoneNumber', IntegerType::class, [
                'label' => 'Phone Number',
                'attr' => [
                    'placeholder' => 'Phone Number',
                ],
                'required' => false,
            ])
            ->add('country', TextType::class, [
                'label' => 'Country',
                'attr' => [
                    'placeholder' => 'Country',
                ],
                'required' => false,
            ])
            ->add('address', TextareaType::class, [
                'label' => 'Address',
                'attr' => [
                    'placeholder' => 'Address',
                ],
                'required' => false,
            ])
            ->add('postalCode', IntegerType::class, [
                'label' => 'Postal Code',
                'attr' => [
                    'placeholder' => 'Postal Code',
                ],
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
