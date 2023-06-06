<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Item;
use App\Entity\User;
use App\Entity\Borrow;
use App\Entity\Category;
use App\Entity\ItemBorrow;
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
            ->setPrice($faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL))
            ->setCategory($categories[$i%count($categories)])
            ->setStock($faker->numberBetween($min = 1, $max = 200));
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
        
        $borrows = Array();
        $itemBorrows=[];
        for ($i = 0; $i < 5; $i++) {
            $borrows[$i] = new Borrow();
            $borrows[$i]
            ->setStartDate($faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now'))
            ->setEndDate($faker->dateTimeBetween($startDate = 'now', $endDate = '+2 years'))
            ->setDescription($faker->word)
            ->setRestituted($faker->boolean($chanceOfGettingTrue = 30))
            ->setStakeholder($users[0])
            ->setProjectManager($users[$i]);
            $entityManager->persist($borrows[$i]);

            for($j=0; $j<2; $j++){
                $itemBorrows[$j] = new ItemBorrow();
                $itemBorrows[$j]
                    ->setItem($items[$j % sizeof($items)])
                    ->setBorrow($borrows[$i])
                    ->setQuantity($faker->numberBetween($min = 0, $max = 1000));
                $entityManager->persist($itemBorrows[$j]);
            }
        }
        $entityManager->flush();
      }
  }
