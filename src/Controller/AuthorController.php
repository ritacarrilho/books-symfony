<?php

namespace App\Controller;

use App\Form\AuthorType;
use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/addAuthor/{id}", name="app_newAuthor", methods={"GET", "POST"}, requirements={"id": "\d+"})
     * @return void
     */
    public function addAuthor(int $id = -1, Request $request, ManagerRegistry $manager) // method get recovers the form click and the method post recovers the form submition | id = -1 in case there is no id passed
    { 
        $author = ($id > 0) ? ($this->authorRepo->find($id)) : (new Author()) ; // instance of a empty object or form to change current author

        $formulary = $this->createForm(AuthorType::class, $author); // form creation
        $formulary->handleRequest($request); // surveillance du request

        if($formulary->isSubmitted() && $formulary->isValid()) { // verify the form - if post request is valid
            $em = $manager->getManager(); // entity manager
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute("app_author"); // redirect to list of authors page
        }

        return $this->render('author/editAuthor.html.twig', [
            'form' => $formulary->createView(),
        ]);
    }

    /**
     * @Route("/deleteAuthor/{id}", name="app_deleteAuthor", methods={"GET", "POST"}, requirements={"id": "\d+"})
     * @return void
     */
    public function deleteAuthor(int $id = -1, Request $request, ManagerRegistry $manager) // method get recovers the form click and the method post recovers the form submition | id = -1 in case there is no id passed
    { 
        
    }
}
