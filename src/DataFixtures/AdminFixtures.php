<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @var UserPasswordEncoderInterface
 */
class AdminFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new Admin();
        $admin->setUsername('admin');
        $admin->setPassword($this->encoder->encodePassword($admin, 'admin'));
        $manager->persist($admin);
        $manager->flush();
    }
}
