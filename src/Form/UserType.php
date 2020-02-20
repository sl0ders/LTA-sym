<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class, ['label' => ' ','attr'=>['placeholder', 'Entrez votre adresse email : ', 'class' => 'p-1']])
            ->add('name', TextType::class,  ['label' => ' ','attr'=>['placeholder', 'Entrez votre nom : ', 'class' => 'p-1']])
            ->add('firstname', TextType::class,  ['label' => ' ','attr'=>['placeholder', 'Entrez votre adresse email : ', 'class' => 'p-1']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
