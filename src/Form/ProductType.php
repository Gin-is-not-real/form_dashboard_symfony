<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('ref')
            ->add('price')
            ->add('advice', TextareaType::class)
            ->add('purchase_date')
            ->add('warranty_end_purchase')
            ->add('category')
            // ->add('manual')
            ->add('manual', FileType::class, [
                // 'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
            ->add('receipt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
