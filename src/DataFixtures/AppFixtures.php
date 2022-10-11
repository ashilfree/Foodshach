<?php

namespace App\DataFixtures;

use App\Entity\Coupon;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
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
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
//        $user = new User();
//        $user->setUsername('admin');
//        $user->setPassword($this->encoder->encodePassword($user, 'Fgdfglpl$84'));
//        $user->setEnabled(true);
//        $manager->persist($user);
//        $manager->flush();

        $coupon = new Coupon();
        $coupon->setCode('ABC123');
        $coupon->setType('fixed');
        $coupon->setValue(3000);
        $manager->persist($coupon);
        $coupon1 = new Coupon();
        $coupon1->setCode('DEF456');
        $coupon1->setType('percent');
        $coupon1->setPercentOff(50);
        $manager->persist($coupon1);
        $manager->flush();
    }
}
