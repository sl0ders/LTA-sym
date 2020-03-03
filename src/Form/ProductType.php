<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,$this->getConfig('Nom du produit','Entrez le nom du produit'))
            ->add('description',TextareaType::class,$this->getConfig('Description du produit','Entrez une description du produit ici ...'))
            ->add('price',IntegerType::class,$this->getConfig('Prix',''))
            ->add('Unity',TextType::class,$this->getConfig('Unité de vente','Entrez l\'unitée du produit'))
            ->add('Quantity',IntegerType::class,['label'=> 'choisissez la quantitée entrée'])
            ->add('pictureFiles', FileType::class, [
                'required' => false,
                'multiple' => true
            ])
            ->add('pictureFilesPng', FileType::class, [
                'required' => false,
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
