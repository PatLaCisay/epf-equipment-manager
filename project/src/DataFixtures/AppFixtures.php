<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Item;
use App\Entity\Room;
use App\Entity\User;
use App\Entity\Group;
use App\Entity\Borrow;
use DateTimeImmutable;
use App\Entity\Category;
use App\Entity\ItemState;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

/*

This method generates dummy data using Faker from https://github.com/fzaninotto/Faker

It's not beautiful code because it's only meant for dev and test purposes, feel free to 
modify anything inside.

*/
class AppFixtures extends Fixture
{
    public function load(ObjectManager $entityManager)
    {
        $faker = Factory::create('fr_FR');
        $categories = Array();
        for ($i = 0; $i < 4; $i++) {
            $categories[$i] = new Category();
            $categories[$i]->setName($faker->word)
                ->setDescription($faker->word)//Lorem.php bugs so we create a single word for description
                ->setPrice($faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL))
                ->setStock($faker->numberBetween($min = 1, $max = 200))
                ->setImage($faker->imageUrl($width = 640, $height = 480))
            ;
            $entityManager->persist($categories[$i]);
        }

        $items = Array();

        for ($i = 0; $i < 12; $i++) {
            $items[$i] = new Item();
            $items[$i]
            ->setName($faker->word)
            ->setState( $faker->randomElement(ItemState::values()))
            ->setCategory($categories[$i%count($categories)]);
            $entityManager->persist($items[$i]);
        }

        $users = Array();
        $admin=new User();
        $admin
            ->setFirstName("admin")
            ->setlastName("admin")
            ->setIsVerified(true)
            ->setRoles(["ROLE_ADMIN"])
            ->setEmail("admin@admin.fr")
            ->setPassword("admin");
        $entityManager->persist($admin);

        for ($i = 0; $i < 12; $i++) {
                $users[$i] = new User();
                $users[$i]
                    ->setFirstName($faker->firstName)
                    ->setlastName($faker->LastName)
                    ->setIsVerified(true)
                    ->setEmail($faker->email)
                    ->setPassword("password");
                $entityManager->persist($users[$i]);
        }

        $rooms = Array();

        for ($i = 0; $i < 12; $i++) {
            $rooms[$i] = new Room();
            $rooms[$i]
            ->setName(ucfirst($faker->randomLetter).$faker->numberBetween($min = 200, $max = 210))
            ->setDescription($faker->word)
            ->setReserved($faker->boolean($chanceOfGettingTrue = 50) );
            $entityManager->persist($rooms[$i]);
        }
        $groups = Array();

        for ($i = 0; $i < 5; $i++) {
            $groups[$i] = new Group();
            $groups[$i]
            ->setName($faker->word)
            ->addUser($users[$i + 1])
            ->addUser($users[$i + 2]);
            $entityManager->persist($groups[$i]);
        }
        
        $borrows = Array();
        $dateFormat = 'Y-m-d';
        for ($i = 0; $i < 5; $i++) {
            $borrows[$i] = new Borrow();
            $borrows[$i]
            ->setStartDate($faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now'))
            ->setEndDate($faker->dateTimeBetween($startDate = 'now', $endDate = '+2 years'))
            ->setDescription($faker->word)
            ->setRestituted($faker->boolean($chanceOfGettingTrue = 30))
            ->setRoom($rooms[$i])
            ->setStakeholder($users[$i])
            ->setTeam($groups[$i])
            ->addItem($items[$i % sizeof($items)])
            ->addItem($items[($i + 1) % sizeof($items)])
            ->addItem($items[($i + 2) % sizeof($items)])
            ->setQuantity($faker->numberBetween($min = 5, $max = 214));
            $entityManager->persist($borrows[$i]);
        }
        
        $entityManager->flush();
      }
  }
