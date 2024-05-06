<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Group;
use Doctrine\ORM\EntityManagerInterface;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $groups = [
            ['name' => "John", "email" => "john@ffff.com", "group_id" => "1"], 
            ['name' => "Dennis", "email" => "dennis@ffff.com", "group_id" => "1"], 
            ['name' => "Ford", "email" => "ford@ffff.com", "group_id" => "2"], 
            ['name' => "Julia", "email" => "julia@ffff.com", "group_id" => "2"], 
            ['name' => "Robert", "email" => "robert@ffff.com", "group_id" => "3"], 
            ['name' => "Alisa", "email" => "alisa@ffff.com", "group_id" => "3"], 
            ['name' => "Alex", "email" => "alex@ffff.com", "group_id" => "3"], 
        ];
        //$entityManager = new EntityManagerInterface();
        foreach ($groups as $group_item) {
            //$group = $entityManager->getRepository(Group::class)->find($group_item["group_id"]); 
            $user = new User();
            $user->setName($group_item["name"]);
            $user->setEmail($group_item["email"]);
            //$user->setGroup($group);
            $user->setGroupId($group_item["group_id"]);
            $manager->persist($user);
            $manager->flush();

            //$this->addReference(sprintf('category-%s', $categoryName), $category);
        }

        $manager->flush();
    }
}
