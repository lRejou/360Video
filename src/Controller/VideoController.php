<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Video;
use App\Repository\VideoRepository;
use App\Entity\Note;
use App\Repository\NoteRepository;



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

        $video360 = $videoRepository->findOneBy(['id' => $video->getId()]);

        return $this->render('video/index.html.twig', ['video' => $video]);
    }
}
