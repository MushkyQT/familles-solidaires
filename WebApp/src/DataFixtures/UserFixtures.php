<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;
    private $faker;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($this->faker->email);
            $user->setFirstName($this->faker->firstName);
            $user->setLastName($this->faker->lastName);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'password'
            ));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
