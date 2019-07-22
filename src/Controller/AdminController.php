<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class AdminController 
{
    /**
     * @var Environment
     */
    private $twig;


    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function index(): Response
    {
        return new Response($this->twig->render('admin/home.html.twig'));
    }

    public function video(): Response
    {
        return new Response($this->twig->render('admin/video.html.twig'));
    }

}