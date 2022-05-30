<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $genres = ['policier', 'historique', 'SF', 'essaie', 'nouvelle', 'love story'];
        $categories = ['poche', 'broché', 'bande dessinée', 'epub'];

        $faker = Faker\Factory::create('fr_FR'); // Factory => object to create data

        for($i = 0; $i < 30; $i++) { // books genetarion (30)
            $book = new Book();
            $book->setTitle( $faker->sentence(6, true) )
                // ->setAuthor($faker->name)
                ->setGenre($genres[rand(0, count($genres) - 1)])
                ->setCategory($categories[rand(0, count($categories) - 1)])
                ->setDateParution($faker->dateTime('2000-01-01'))
                ->setDateEdition($faker->dateTime('now'))
                ->setNbrPage($faker->randomNumber(3))
                ->setSynopsis($faker->paragraph(5, true))
                ->setEan($faker->ean13)
                ->setIsbn($faker->isbn13)
                ->setEditor($faker->company);

            $manager->persist($book); // save the data into a generic array - duplo virtual do objecto criado em memoria antes de guardar na base de dados
        }

        $manager->flush();
    }
}
