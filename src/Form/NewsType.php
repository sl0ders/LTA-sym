<?php

namespace App\Form;

use App\Entity\News;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Title', TextType::class, ['label' => 'Titre de la news'])
            ->add('content', TextareaType::class, ['label' => 'Contenu de la news'])
            ->add('filename', FileType::class, [
                'required' => false,
                'label' => 'Choisissez une image pour illustrer la news'
            ])
            ->add('product', EntityType::class, [
                'attr' => [
                    'class' => 'browser-default custom-select'
                ],
                'class' => Product::class,
                'label' => 'Produit lié a l\'article'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => News::class,
        ]);
    }
}
