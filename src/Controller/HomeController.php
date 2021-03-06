<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @var BookRepository
     */
    private $bookRepo;

    //injection of BookRepository
    public function __construct(BookRepository $bookRepository) 
    { 
        $this->bookRepo = $bookRepository; // the BookRepository is available in all method of this class
    }

// DECLARE ROUTES - replaces routes in routes.yml
    /**
     * @Route("/", name="app_home", methods={"GET", "PUT"})
     * @return Response
     */
    public function welcome() 
    {
        // call the render to connect the controller to the view
        return $this->render( "front/home.html.twig", [] ); // empty array in case is needed to pass parameters

        /**return a object type Response (html page) -> request response
        return new Response("
            <html>
                <head>
                    <title>Welcome to Symfony</title>
               </head>
                <body>
                    <h1>Hello</h1>
                    <ul>
                        <li><a href='/page/1'>Page 1</a></li>
                        <li><a href='/page/2'>Page 2</a></li>
                    </ul>
                    <p>
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Earum rem unde explicabo? Mollitia eius saepe beatae non natus sit ab, perferendis corrupti illo amet eaque quo, nihil distinctio! Expedita, assumenda!
                        Architecto adipisci impedit consequatur soluta enim illo nemo vel expedita doloribus dolor ducimus, dignissimos ad veniam qui velit ratione atque ipsam quisquam error, sequi saepe sed provident? Veritatis, consectetur rem.
                        Ducimus ab architecto sapiente veritatis laboriosam! Harum voluptate veritatis vel minima aliquam ipsum consectetur quod, minus voluptas sit aliquid, distinctio perferendis amet ullam reiciendis nisi. Laboriosam placeat repudiandae porro nulla!
                        Voluptatibus perspiciatis enim ipsa, non voluptate sint adipisci nam rerum quas vel, sequi, eum atque sit perferendis! Quos, ducimus, laborum quidem exercitationem debitis perferendis dolorum id sunt expedita rerum nihil?
                        Ea minus veniam earum hic labore ipsa, nobis, dignissimos animi laboriosam eum aliquid, tempore aperiam dolore accusantium perspiciatis consequatur obcaecati vero sed quia aliquam doloremque voluptates atque! Voluptatum, ullam eius?
                    </p>
                </body>
            <//html>
        ");*/
    } 


    /** Variables injection into strings
     * "$num"
     * 'bla' . $num . 'bla'
     * `bla $num bla`
     */

     /**
     * @Route("/page/{numPage}", name="app_page", methods={"GET"})
     * @return Response
     */
    public function page(string $numPage) 
    {
        return $this->render("front/page.html.twig", [
            // key used in the view => variable
            "numPage" => $numPage,
        ]);

        /**return new Response("
             <html>
                <head>
                    <title>Page $numPage</title>
                </head>
                <body>
                    <h1>Hello! You are ate $numPage page</h1>
                    <ul>
                        <li><a href='/home'>Home</li>
                        <li><a href='/page/1'>Page 1</a></li>
                        <li><a href='/page/2'>Page 2</a></li>
                    </ul>
                    <p>
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Earum rem unde explicabo? Mollitia eius saepe beatae non natus sit ab, perferendis corrupti illo amet eaque quo, nihil distinctio! Expedita, assumenda!
                        Architecto adipisci impedit consequatur soluta enim illo nemo vel expedita doloribus dolor ducimus, dignissimos ad veniam qui velit ratione atque ipsam quisquam error, sequi saepe sed provident? Veritatis, consectetur rem.
                        Ducimus ab architecto sapiente veritatis laboriosam! Harum voluptate veritatis vel minima aliquam ipsum consectetur quod, minus voluptas sit aliquid, distinctio perferendis amet ullam reiciendis nisi. Laboriosam placeat repudiandae porro nulla!
                        Voluptatibus perspiciatis enim ipsa, non voluptate sint adipisci nam rerum quas vel, sequi, eum atque sit perferendis! Quos, ducimus, laborum quidem exercitationem debitis perferendis dolorum id sunt expedita rerum nihil?
                        Ea minus veniam earum hic labore ipsa, nobis, dignissimos animi laboriosam eum aliquid, tempore aperiam dolore accusantium perspiciatis consequatur obcaecati vero sed quia aliquam doloremque voluptates atque! Voluptatum, ullam eius?
                    </p>
                </body>
            <//html>
        ");*/
    }

    /**
     * @Route("/ArticlesList", name="app_list", methods={"GET"})
     */
    public function listArticles()
    {
        $articles = [
            ['title' => 'Java\'s Rules', 'comment' => 'Learn all about Java'],
            ['title' => 'The beauty of C', 'comment' => 'Code C with elegance'],
            ['title' => 'My beloved Wordpress', 'comment' => 'A special relationshio with Gabriel(s)'],
        ];

        return $this->render('front/template_part/_listArticles.html.twig', [
            "articles" => $articles
        ]);
    }

    /**
     * @Route("/books", name="app_books", methods={"GET"})
     * @return Response 
     */
    public function bookList() 
    {
        // $books = $this->getDoctrine()->getRepository(Book::class)->findAll(); // doctrine allows to access to getRepository (to get the data)
        // $books = $bookRepository->findAll(); find method in bookRepository
        // $books = $this->bookRepo->findAll();  find method in bookRepository with injection

        $books = $this->bookRepo->findAllBooks();
        // dump($books);

        return $this->render("front/books.html.twig", [
            'books' => $books
        ]);
    }

    /**
     * @Route("/bookDateFilter", name="app_dateFiltered", methods={"POST"})
     * @return void 
     */
    public function listBookFilter(Request $request) // request allows to recover the parameters passed in the request post
    {

        $datePost = $request->get('date');
        // dump($datePost);
        $books = $this->bookRepo->findByPublishUnder($datePost);

        return $this->render("front/booksFiltered.html.twig", [
            "books" => $books
        ]);
    }

    /**
     * @Route("/latestBooks", name="app_latest", methods={"GET"})
     * @return void 
     */
    public function latestBooks() // request allows to recover the parameters passed in the request post
    {
        $books = $this->bookRepo->findLatest();

        return $this->render("front/latestBooks.html.twig", [
            'books' => $books,
        ]);
    }

    /**
     * @Route("/addBook", name="app_addBook", methods={"GET", "POST"})
     * @return void 
     */
    public function addBook() // request allows to recover the parameters passed in the request post
    {
        $book = new Book;
        $b_form = $this->createForm(BookType::class, $book);

        return $this->render("front/form/bookForm.html.twig", [
            'form' => $b_form->createView(),
        ]);
    }

    /**
     * @Route("/login", name="app_login")
     * @return void 
     */
    public function login(AuthenticationUtils $authenticationUtils) // user login
    { 
        $error = $authenticationUtils->getLastAuthenticationError();
    
        $lastIdent = $authenticationUtils->getLastUsername();

        return $this->render("front/form/login.html.twig", [
            'lastIdent' => $lastIdent,
            'error' => $error
        ]);
    }
}