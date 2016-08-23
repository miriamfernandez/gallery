<?php

/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 22/08/2016
 * Time: 14:36
 */
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        $userAdmin->setPassword(password_hash('admin', PASSWORD_BCRYPT, array('cost' => 13)));
        $userAdmin->setEmail('admin@admin.com');
        $userAdmin->setRoles(array('ROLE_ADMIN'));

        $manager->persist($userAdmin);
        $manager->flush();

        $user = new User();
        $user->setUsername('user');
        $user->setPassword(password_hash('user', PASSWORD_BCRYPT, array('cost' => 13)));
        $user->setEmail('user@user.com');
        $user->setRoles(array('ROLE_USER'));

        $manager->persist($user);
        $manager->flush();
    }
}