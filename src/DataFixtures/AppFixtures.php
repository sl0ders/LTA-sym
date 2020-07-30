<?php

namespace App\DataFixtures;

use App\Entity\Avatar;
use App\Entity\News;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
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
        $faker = Factory::create("frFr");
        for ($i = 1; $i <= 10; $i++) {
            $new = new News();
            $new
                ->setContent($faker->text)
                ->setTitle($faker->title)
                ->setCreatedAt(new DateTime());
            $manager->persist($new);
        }
        for ($i = 1; $i <= 12; $i++) {
        $avatar = new Avatar();
        $avatar
            ->setName("avatar" . $i . ".png");
        $manager->persist($avatar);
        $manager->flush();
    }
        $avatars = $manager->getRepository(Avatar::class)->findAll();
        $user = new User();
        $user
            ->setEmail("sl0ders@gmail.com")
            ->setPassword($this->encoder->encodePassword($user, '258790'))
            ->setRoles(["ROLE_ADMIN"])
            ->setName("Sommesous")
            ->setFirstName("Quentin")
            ->setUsername("sl0ders")
            ->setStatus("admin")
            ->setAvatar($faker->randomElement($avatars))
            ->setCreatedAt(new DateTime());
        $manager->persist($user);




        $manager->flush();
    }
}
