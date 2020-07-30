<?php

namespace App\Form;

use App\Entity\Stock;
use Flit\ThirdPartyBundle\Entity\Provider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity',  NumberType::class, [
                'label' => false,
                "type" => "fractional",
                "scale" => 2,
                "mapped" => true,
                'attr' => array('class' => 'text-right min-box-tax')
            ])
            ->add('id', HiddenType::class, [
                    "mapped" => false
                ]
            );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Stock::class,
            'required' => false,
            'allow_extra_fields' => true,
        ));
    }
}
