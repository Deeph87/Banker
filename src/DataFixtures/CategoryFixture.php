<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixture extends Fixture
{
    private $categories;

    public function __construct() {
        $this->categories = ['Personal', 'Store', 'Food', 'Restaurant', 'Taxi'];
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->categories as $name) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
