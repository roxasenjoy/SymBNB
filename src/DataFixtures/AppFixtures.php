<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{

    /*
     * php bin/console doctrine:fixtures:load
     */
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('FR-fr');

        /* Créer une publication */
        for($i = 1; $i <= 30; $i++){
            $ad = new Ad;

            $title = $faker->sentence();
            $coverImage = 'http://placehold.it/1000x400';
            $introduction = $faker->paragraph(2);
            $content = '<p>' .  join ('<p></p>', $faker->paragraphs(5)) . '</p>';



            $ad->setTitle($title)
                ->setCoverImage($coverImage)
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setPrice(mt_rand(40,200))
                ->setRooms(mt_rand(1,5));

            /* Créer des photos pour chaque AD */
            for($j = 1; $j < mt_rand(2,5); $j++){
                $image = new Image();

                $image->setUrl('http://placehold.it/1000x1000')
                    ->setCaption($faker->sentence())
                    ->setAd($ad);

                $manager->persist($image);
            }

            $manager->persist($ad);
        }

        $manager->flush();
    }
}
