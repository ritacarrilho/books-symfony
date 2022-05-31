<?php

namespace App\Controller;

use App\Form\AuthorType;
use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    private $authorRepo;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepo = $authorRepository;
    }

    /**
     * @Route("/author", name="app_author")
     */
    public function listAuthor(): Response
    {
        $authors = $this->authorRepo->findAll();

        return $this->render('author/listAuthor.html.twig', [
            'authors' => $authors,
        ]);
    }

    /**
     * @Route("/addAuthor", name="app_newAuthor", methods={"GET", "POST"})
     * @return void
     */
    public function addAuthor() // method get recovers teh form click and the method post recovers the form submition 
    {
        $formulary = $this->createForm(AuthorType::class);

        return $this->render('author/editAuthor.html.twig', [
            'form' => $formulary->createView(),
        ]);
    }

}
