<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Video;
use App\Repository\VideoRepository;


/**
 * @Route("/video")
 */
class VideoController extends AbstractController
{
    /**
     * @Route("/", name="video")
     */
    public function index(VideoRepository $videoRepository)
    {
        return $this->render('video/index.html.twig', [
            'controller_name' => 'VideoController',
        ]);
    }

    /**
     * @Route("/{id}", name="video_show", methods={"GET"})
     */
    public function show(VideoRepository $videoRepository, Video $video){
        return $this->render('video/index.html.twig', [
            'video' => $videoRepository->findOneBy(
                ['id' => $video->getId()]
            )
        ]);
    }
}
