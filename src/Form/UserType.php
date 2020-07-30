<?php

namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    "placeholder" => "Adresse email"
                ],
                'label' => "Entrez votre adresse email"
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Répéter le mot de passe'],
            ])
            ->add('firstname', TextType::class, [
                'attr' => [
                    'placeholder' => 'Votre prenom'
                ],
                'label' => "Entrez votre prenom"
            ])
            ->add('name', TextType::class, [
                'attr' => [
                    'placeholder' => 'Votre Nom'
                ],
                'label' => "Entrez votre Nom"
            ])
            ->add('username', TextType::class, [
                'attr' => [
                    'placeholder' => 'Votre pseudo'
                ],
                'label' => "Entrez votre pseudo"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
