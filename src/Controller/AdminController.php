<?php
namespace App\Controller;

use Twig\Environment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\VideoUser;
use App\Repository\VideoUserRepository;
use App\Entity\Video;
use App\Repository\VideoRepository;

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

    /**
     * @Route("/validationVideoAdmin/{id}", name="admin_Valisationvideo", methods={"GET"})
     */
    public function validationVideo(VideoUserRepository $videoUserRepository, VideoUser $videoUser, VideoRepository $videoRepository, Video $video): Response
    {
        $video =  $videoUserRepository->findOneBy(['id' => $videoUser->getId()]);

        $date = new \DateTime();

        $video3D = new video();
        $video3D->setName($video->getName());
        $video3D->setNickname($video->getNickname());
        $video3D->setDescription($video->getDescription());
        $video3D->setLink($video->getLink());
        $video3D->setDate($date);
    
        $em = $this->getDoctrine()->getManager();
        $em->persist($video3D);
        $em->flush();

        $em->remove($video);
        $em->flush();

        return $this->render('admin/validationVideo.html.twig');
    }

    /**
     * @Route("/deleteVideoAdmin/{id}", name="admin_Deletevideo", methods={"GET"})
     */
    public function deleteVideoAdmin(VideoUserRepository $videoUserRepository, VideoUser $videoUser): Response
    {
        $video =  $videoUserRepository->findOneBy(['id' => $videoUser->getId()]);

        $em = $this->getDoctrine()->getManager();
        $em->remove($video);
        $em->flush();

        return $this->render('admin/deleteVideo.html.twig');
    }

}