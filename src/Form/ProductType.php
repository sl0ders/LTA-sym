<?php

namespace App\Form;

use App\Entity\Picture;
use App\Entity\Product;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, $this->getConfig('Nom du produit', 'Entrez le nom du produit'))
            ->add('description', TextareaType::class, $this->getConfig('Description du produit', 'Entrez une description du produit ici ...'))
            ->add('price', NumberType::class, $this->getConfig('Prix', ''))
            ->add('Unity', TextType::class, $this->getConfig('Unité de vente', 'Entrez l\'unitée du produit'))
            ->add('Quantity', IntegerType::class, ['label' => 'choisissez la quantitée entrée'])
            ->add('filenameJpg', FileType::class, [
                'label' => 'Grande image du produit au format jpg ou jpeg',
                'mapped' => false,
                'required' => false,
            ])
            ->add('filenamePng', FileType::class, [
                'label' => 'Grande image du produit au format png',
                'mapped' => false,
                'required' => false,
//                'constraints' => [
//                    'maxSize' => '1024k',
//                    'mimeTypes' => "png",
//                    'mimeTypesMessage' => 'Veuillez choisir une image au format png de 1 mo maximum',
//                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
