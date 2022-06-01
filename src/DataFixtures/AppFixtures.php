<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Category;
use App\Entity\Genre;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**
     * @var
     */
    private $pass_hasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->pass_hasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $genres = ['policier', 'historique', 'SF', 'essaie', 'nouvelle', 'love story'];
        $categories = ['poche', 'broché', 'bande dessinée', 'epub'];

        $faker = Faker\Factory::create('fr_FR'); // Factory => object to create data

        //generate USER type admin
        $userOne = new User();
        $userOne->setFirstName("Alexander")
                ->setLastName("Thegreat")
                ->setEmail("alexander@thegreat.gk")
                ->setRole("ROLE_ADMIN")
                ->setPassword($this->pass_hasher->hashPassword($userOne, "admin"));
        $manager->persist( $userOne);
        
        //generate USER type admin
        $userTwo = new User();
        $userTwo->setFirstName("Khan")
                ->setLastName("Gengis")
                ->setEmail("atila@lehun.com")
                ->setRole("ROLE_ADMIN")
                ->setPassword($this->pass_hasher->hashPassword($userTwo, "admin"));
        $manager->persist( $userTwo);
                
        // GENRE traitment
        foreach($genres as $kg => $genre) {
            $gn = new Genre(); // instanciate a new genre object
            $gn->setName($genre); // add a name thou setter method

            $manager->persist( $gn); // save the data into a generic array (ORM system) to later save onto genre table

            $this->addReference('genre-'. $kg, $gn); // add genre reference to pass to method addGenre in book object
        }

        // CATEGORY traitment
        foreach($categories as $kc => $category) {
            $cat = new Category();
            $isornot = ($category == 'epub') ? (true) : (false) ;

            $cat->setLabel($category)->setElectronic($isornot);
            $manager->persist( $cat);
            $this->addReference('cat-'.$kc, $cat);
        }

        // AUTHOR traitment
        for($i=0; $i < 15; $i++) { // object Author creation - random generation of 15 authors
            $author = new Author();
            $author->setLastName( $faker->lastName )
                    ->setFirstName( $faker->firstName )
                    ->setBirthDate( $faker->dateTime(2004-01-01) ); 

            $manager->persist( $author);  // save the data into a generic array (ORM system) - virtual double of the object created in memory before save into DB

            // creation of reference array : saves a reference of new Object into the temporary array
            $this->addReference('author-' . $i, $author); // key => value array ex author[$i] = $author['firstName', 'lastName', birthDate]
        }  

        // BOOKS traitment
        for($i = 0; $i < 30; $i++) { // books genetarion (30)
            $book = new Book();
            $book->setTitle( $faker->sentence(6, true) )
                ->setGenre( $this->getReference('genre-' . rand(0, count($genres) - 1))) 
                ->setDateParution( $faker->dateTime('2000-01-01') ) 
                ->setDateEdition( $faker->dateTime('now') )
                ->setNbrPage( $faker->randomNumber(3) )
                ->setSynopsis( $faker->paragraph(5, true) )
                ->setEan( $faker->ean13 )
                ->setIsbn( $faker->isbn13 )
                ->setEditor( $faker->company );

            // add category reference into books (because it has a intermediate table)
            $maxCat = rand(1, count($categories));
            for($u = 1; $u <= $maxCat; $u++) {
                $book->addCategory($this->getReference('cat-' . rand(0, count($categories) - 1)));
            }

            // add authors reference into books (because it has a intermediate table)
            $maxAuthor = rand(1, 5); // random max number of authors (iterations number)
            for($j = 1; $j <= $maxAuthor; $j++) {
                $book->addAuthor($this->getReference('author-' . rand(0, 14)));
            }
            
            $manager->persist( $book ); // save the data into a generic array (ORM system) - virtual double of the object created in memory before save into DB
        }

        $manager->flush();
    }
}
