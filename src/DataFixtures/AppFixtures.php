<?php

namespace App\DataFixtures;

use App\Entity\Ads;
use App\Entity\Categories;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i < 3; $i++) { 
            $ad = new Ads();
            $ad->setTitle('Titre ' . $i);
            $ad->setImageUrl('https://picsum.photos/id/5' . $i . '/200/300');
            $ad->setDescription($i . ' -Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nesciunt saepe repellat maxime nulla vero quaerat maiores corrupti quam minima reiciendis rem a totam, quibusdam, quia repudiandae nemo dolores perferendis voluptate.');
            $manager->persist($ad);
        }

        // for ($i=0; $i < 3; $i++) { 
        //     $user = new Users();
        //     $user->setEmail('tetuanui@hotmail.com');
        //     $user->setImageUrl('https://picsum.photos/id/5' . $i . '/200/300');
        //     $ad->setDescription($i . ' -Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nesciunt saepe repellat maxime nulla vero quaerat maiores corrupti quam minima reiciendis rem a totam, quibusdam, quia repudiandae nemo dolores perferendis voluptate.');
        //     $manager->persist($ad);
        // }

        $manager->flush();
    }
}
