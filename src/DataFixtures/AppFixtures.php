<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Topic;
use App\Entity\Message;
use App\Entity\SubTopic;
use App\Entity\UserType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $type = new UserType();
        $type->setLabel("Membre");

        $manager->persist($type);

        $user = new User();
        $user->setUsername("boubou");
        $user->setPassword("babidi");
        $user->setIdUserType($type);

        $manager->persist($user);

        $faker = \Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 5; $i++) {

            $topic = new Topic();
            $topic->setTitle($faker->sentence($nbWords = 3, $variableNbWords = true));
            $topic->setDescription($faker->paragraph($nbSentences = 3, $variableNbSentences = true));

            $manager->persist($topic);
            for ($j = 0; $j < 30; $j++) {

                $subTopic = new SubTopic();
                $subTopic->setTitle($faker->sentence($nbWords = 10, $variableNbWords = true));
                $subTopic->setTopic($topic);
                $subTopic->setIdUser($user);
                $subTopic->setCreatedAt($faker->dateTimeBetween('-6 months'));
                
                $manager->persist($subTopic);
                for ($k = 0; $k < 10; $k++) {

                    $message = new Message();
                    $message->setText($faker->paragraph($nbSentences = 30));
                    $message->setTopic($topic);
                    $message->setIdUser($user);
                    $message->setCreatedAt($faker->dateTimeBetween('-3 months'));
                    $message->setSubTopic($subTopic);
                    
                    $manager->persist($message);
                }
            }
        }
        

        $manager->flush();
    }
}
