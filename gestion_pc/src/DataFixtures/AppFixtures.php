<?php

namespace App\DataFixtures;

use App\Entity\Attribution;
use App\Entity\Computer;
use App\Entity\User;
use DateTime;
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

        for ($i = 1; $i <= 5; $i++) {
            $computer = new Computer();
            $computer->setName('PC' . $i);
            $manager->persist($computer);
            for ( $y=8; $y<19; $y++){
                $attribution = (new Attribution())
                    ->setHour($y)
                    ->setDate(new DateTime())
                    ->setComputer($computer);
                $manager->persist($attribution);
            }
        }
        $adminUser->setName('Alison Barret')
            ->setEmail('barretalison@gmail.com')
            ->setHash($this->encoder->encodePassword($adminUser, 'password'));

        $manager->persist($adminUser);

        $manager->flush();
    }
}

