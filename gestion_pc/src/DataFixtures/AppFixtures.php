<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $adminUser = new User();

        $adminUser->setName('Alison Barret')
            ->setEmail('barretalison@gmail.com')
            ->setHash($this->encoder->encodePassword($adminUser, 'password'));

        $manager->persist($adminUser);

        $manager->flush();
    }
}

