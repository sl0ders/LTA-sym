<?php


namespace App\Form;

use App\Entity\Orders;
use App\Entity\Stock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class StockCollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity', CollectionType::class, [
                'label' => false,
                'entry_type' => StockType::class,
                'allow_add' => false,
                'allow_delete' => false,
                'delete_empty' => false,
                'prototype' => true,
                'required' => false,
                'allow_extra_fields' => true
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
            'allow_extra_fields' => true,
        ));
    }
}

