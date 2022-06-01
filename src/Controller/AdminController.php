<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin/home", name="app_dashboard", methods={"GET"})
     * 
     */
    public function homeAdmin()
    {
        return $this->render("admin/dashboard.html.twig", []);
    }
}