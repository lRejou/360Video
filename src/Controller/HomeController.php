<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use App\Entity\Video;
use App\Repository\VideoRepository;

class HomeController 
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
        return new Response($this->twig->render('pages/home.html.twig'));
    }

    public function annuaire(VideoRepository $videoRepository): Response
    {
        return new Response($this->twig->render('pages/annuaire.html.twig', [
            'videos' => $videoRepository->findAll()
        ]));
    }

    public function tuto(): Response
    {
        return new Response($this->twig->render('pages/tuto.html.twig'));
    }

    public function video(): Response
    {
        return new Response($this->twig->render('pages/video.html.twig'));
    }

    public function addvideo(): Response
    {
        return new Response($this->twig->render('pages/addvideo.html.twig'));
    }

    public function login(): Response
    {
        return new Response($this->twig->render('pages/login.html.twig'));
    }



    public function cgu(): Response
    {
        return new Response($this->twig->render('pages/cgu.html.twig'));
    }


}