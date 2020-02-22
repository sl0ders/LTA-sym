<?php

namespace App\DataFixtures;

use App\Entity\Avatar;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail("sl0ders@gmail.com");
        $user->setPassword($this->encoder->encodePassword($user,'258790'));
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setName("Sommesous");
        $user->setFirstName("Quentin");
        $user->setUsername("sl0ders");
        $user->setActive("2");
        $user->setCreatedAt(new \DateTime());
        $manager->persist($user);

        for( $i = 1; $i <= 12; $i++){
            $avatar = new Avatar();
            $avatar->setName("avatar".$i.".png");
            $manager->persist($avatar);
        }
        $manager->flush();
    }
}
