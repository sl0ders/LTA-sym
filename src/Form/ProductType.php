<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Stock;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ProductType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,$this->getConfig('Nom du produit','Entrez le nom du produit'))
            ->add('description',TextareaType::class,$this->getConfig('Description du produit','Entrez une description du produit ici ...'))
            ->add('price',IntegerType::class,$this->getConfig('Prix',''))
            ->add('Unity',TextType::class,$this->getConfig('Unité de vente','Entrez l\'unitée du produit'))
            ->add('stock',EntityType::class,['class' => Stock::class, 'label'=> 'choisissez le stock associé'])
            ->add('pictureFiles', FileType::class, [
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
