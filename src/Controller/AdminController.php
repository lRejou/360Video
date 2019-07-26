<?php
namespace App\Controller;

use Twig\Environment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\VideoUser;
use App\Repository\VideoUserRepository;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
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
     * @Route("/", name="admin_index", methods={"GET"})
     */
    public function index(VideoUserRepository $videoUserRepository): Response
    {
        return new Response($this->twig->render('admin/home.html.twig', [
            'videosUser' => $videoUserRepository->findAll()
        ]));
    }

    /**
     * @Route("/video/{id}", name="admin_video", methods={"GET"})
     */
    public function video(VideoUserRepository $videoUserRepository, VideoUser $videoUser): Response
    {
        return $this->render('admin/video.html.twig', [
            'video' => $videoUserRepository->findOneBy(
                ['id' => $videoUser->getId()]
            )
        ]);
        //return new Response($this->twig->render('admin/video.html.twig'));
    }

}