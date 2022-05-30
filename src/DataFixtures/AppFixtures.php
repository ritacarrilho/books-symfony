<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Author;
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

        for($i=0; $i < 15; $i++) { // object Author creation - random generation of 15 authors
            $author = new Author();
            $author->setLastName( $faker->lastName )
                    ->setFirstName( $faker->firstName )
                    ->setBirthDate( $faker->dateTime(2004-01-01) ); 

            $manager->persist( $author);  // save the data into a generic array (ORM system) - virtual double of the object created in memory before save into DB

            // creation of reference array : saves a reference of new Object into the temporary array
            $this->addReference('author-' . $i, $author); // key => value array ex author[$i] = $author['firstName', 'lastName', birthDate]
        }  

        for($i = 0; $i < 30; $i++) { // books genetarion (30)
            $book = new Book();
            $book->setTitle( $faker->sentence(6, true) )
                ->addAuthor( $author )
                ->setGenre( $genres[rand(0, count($genres) - 1)])
                ->setCategory( $categories[rand(0, count($categories) - 1)] )
                ->setDateParution( $faker->dateTime('2000-01-01') ) 
                ->setDateEdition( $faker->dateTime('now') )
                ->setNbrPage( $faker->randomNumber(3) )
                ->setSynopsis( $faker->paragraph(5, true) )
                ->setEan( $faker->ean13 )
                ->setIsbn( $faker->isbn13 )
                ->setEditor( $faker->company );

            // add authors references into books
            $maxAuthor = rand(1, 5); // random max number of authors (iterations number)
            for($j = 1; $j <= $maxAuthor; $j++) {
                $book->addAuthor($this->getReference('author-' . rand(0, 14)));
            }

            $manager->persist( $book ); // save the data into a generic array (ORM system) - virtual double of the object created in memory before save into DB
        }

        $manager->flush();
    }
}
