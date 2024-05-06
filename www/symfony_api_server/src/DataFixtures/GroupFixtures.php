<?php

namespace App\DataFixtures;

use App\Entity\Group;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GroupFixtures extends Fixture //implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $groups = ['Group1', 'Group2', 'Group3'];

        foreach ($groups as $groupName) {
            $group = new Group();
            $group->setName($groupName);
            $manager->persist($group);
            $manager->flush();

            //$this->addReference(sprintf('category-%s', $categoryName), $category);
        }
    }

//    public function getDependencies(): array
//    {
//        return [OtherFixtures::class];
//    }
}
