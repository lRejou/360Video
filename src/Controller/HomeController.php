<?php

namespace App\Controller;



use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use App\Entity\Video;
use App\Repository\VideoRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
    /**
     * @var Environment
     */
    private $twig;


    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return new Response($this->twig->render('pages/home.html.twig'));
    }

    /**
     * @Route("/annuaire", name="annuaire")
     */
    public function annuaire(VideoRepository $videoRepository): Response
    {
        return new Response($this->twig->render('pages/annuaire.html.twig', [
            'videos' => $videoRepository->findAll()
        ]));
    }

    /**
     * @Route("/tuto", name="tuto")
     */
    public function tuto(): Response
    {
        return new Response($this->twig->render('pages/tuto.html.twig'));
    }

    /**
     * @Route("/addvideo", name="addvideo")
     */
    public function addvideo(): Response
    {
        return new Response($this->twig->render('pages/addvideo.html.twig'));
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(): Response
    {
        return new Response($this->twig->render('pages/login.html.twig'));
    }

    /**
     * @Route("/cgu", name="cgu")
     */
    public function cgu(): Response
    {
        return new Response($this->twig->render('pages/cgu.html.twig'));
    }

    /**
     * @Route("/validation", name="validation", methods={"POST"})
     */
    public function validation(VideoRepository $videoRepository, Request $request)
    {


        $date = new \DateTime();
        $currentDate = $date->format('Y-m-d');

        $video3D = new video();
        $video3D->setName($request->get('titre'));
        $video3D->setNickname($request->get('pseudo'));
        $video3D->setDescription($request->get('description'));
        $video3D->setLink($request->get('link'));
        $video3D->setDate($date);

        $em = $this->getDoctrine()->getManager();
        $em->persist($video3D);
        $em->flush();



        return new Response($this->twig->render('pages/validation.html.twig'));
    }


}