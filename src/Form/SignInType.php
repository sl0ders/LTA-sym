<?php

namespace App\Form;

use App\Entity\Avatar;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignInType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, $this->getConfig('Adresse email...', 'Entrez votre adresse email : '))
            ->add('Password', PasswordType::class, $this->getConfig('Mot de passe...', 'Entrez un mot de passe : '))
            ->add('confirmPassword', PasswordType::class, $this->getConfig("Confirmation...", "Confirmez votre mot de passe : "))
            ->add('name', TextType::class, $this->getConfig("Votre nom...", "Entrez votre nom de famille : "))
            ->add('firstname', TextType::class, $this->getConfig("Votre prénom...", "Entrez votre prénom : "));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
