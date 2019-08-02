<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use App\Entity\Video;
use App\Repository\VideoRepository;
use App\Entity\VideoUser;
use App\Repository\VideoUserRepository;
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
        $videos360 = $videoRepository->findAll();

    
        return new Response($this->twig->render('pages/annuaire.html.twig', [
            'videos' => $videos360
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
     * @Route("/cgu", name="cgu")
     */
    public function cgu(): Response
    {
        return new Response($this->twig->render('pages/cgu.html.twig'));
    }

    /**
     * @Route("/validation", name="validation", methods={"POST" , "GET"})
     */
    public function validation(VideoUserRepository $videoUserRepository, Request $request)
    {
        //$date = new \DateTime();
        //$currentDate = $date->format('Y-m-d');

        if(!empty($request->get('titre')) && !empty($request->get('pseudo')) && !empty($request->get('description')) && !empty($request->get('link'))){

            $video3D = new videouser();
            $video3D->setName($request->get('titre'));
            $video3D->setNickname($request->get('pseudo'));
            $video3D->setDescription($request->get('description'));
            $video3D->setLink($request->get('link'));
            //$video3D->setDate($date);
    
            $em = $this->getDoctrine()->getManager();
            $em->persist($video3D);
            $em->flush();

            $message = "accept";

        }
        else{

            $message = "error";

        }

        return $this->render('pages/validation.html.twig', [
            'message' => $message
        ]);

        //return new Response($this->twig->render('pages/validation.html.twig'));
    }


}