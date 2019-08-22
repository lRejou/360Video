<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use App\Entity\Video;
use App\Repository\VideoRepository;
use App\Entity\VideoUser;
use App\Repository\VideoUserRepository;
use App\Entity\Note;
use App\Repository\NoteRepository;
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
     * @Route("/ml", name="cgu")
     */
    public function ml(): Response
    {
        return new Response($this->twig->render('pages/ml.html.twig'));
    }

    /**
     * @Route("/validation", name="validation", methods={"POST" , "GET"})
     */
    public function validation(VideoUserRepository $videoUserRepository, Request $request)
    {
        //$date = new \DateTime();
        //$currentDate = $date->format('Y-m-d');

        if(!empty($request->get('titre')) && !empty($request->get('pseudo')) && !empty($request->get('description')) && !empty($request->get('link'))){

            $url = $request->get('link');

            //recaptcha
            $code = $request->get('g-recaptcha-response');
            $ip = NULL;
            if (empty($code)) {
                $message = "error";
                return $this->render('pages/validation.html.twig', [
                    'message' => $message
                ]);
            }
            $params = [
                'secret'    => "6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe",
                'response'  => $code
            ];
            if( $ip ){
                $params['remoteip'] = $ip;
            }
            $urlCaptcha = "https://www.google.com/recaptcha/api/siteverify?" . http_build_query($params);
            if (function_exists('curl_version')) {
                $curl = curl_init($urlCaptcha);
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_TIMEOUT, 1);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                $response = curl_exec($curl);
            } else {
                $message = "error";
                return $this->render('pages/validation.html.twig', [
                    'message' => $message
                ]);
            }
        
            if (empty($response) || is_null($response)) {
                $message = "error";
                return $this->render('pages/validation.html.twig', [
                    'message' => $message
                ]);
            }

            $json = json_decode($response);


            if( preg_match('/youtu.be/', $url) ){
                $url = parse_url($url, PHP_URL_PATH);
                $url=substr($url,-strlen($url)+1);
            }
            else{
                $url = parse_url($url, PHP_URL_QUERY);
                $url=substr($url,-strlen($url)+2);
            }

            $video3D = new videouser();
            $video3D->setName($request->get('titre'));
            $video3D->setNickname($request->get('pseudo'));
            $video3D->setDescription($request->get('description'));
            $video3D->setLink($url);
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

    /**
     * @Route("/vote/{id}/{note}", name="vote" , methods={"GET"})
     */
    public function vote(Request $request, NoteRepository $noteRepository, VideoRepository $videoRepository)
    {
        $adressIP = $_SERVER['REMOTE_ADDR'];
        $video360 = $videoRepository->findOneBy(['id' => $request->get('id')]);
        $allNotebyIP = $noteRepository->findBy(['video' => $video360 , 'user' => $adressIP ]);

        if(count($allNotebyIP) > 2){
            $message = "Vous avez deja voté 3 fois pour cette video";
        }
        else{
            $video360 = $videoRepository->findOneBy(['id' => $request->get('id')]);


            $noteVideo = new Note();
            $noteVideo->setVideo($video360);
            $noteVideo->setNote($request->get('note'));
            $noteVideo->setUser($adressIP);
    
    
            $em = $this->getDoctrine()->getManager();
            $em->persist($noteVideo);
            $em->flush();
    
            $message = "Votre note a bien été prise en compte";
    
        }

        return $this->render('pages/vote.html.twig', [
            'message' => $message
        ]);
    }

    /**
     * @Route("/loadvideo/{nb}/{loadBy}", name="loadvideo" , methods={"GET"})
     */
    public function loadVideo(Request $request, VideoRepository $videoRepository)
    {
        $nbload = $request->get('nb');
        if($nbload == 0){
            $nbload = 0;
        }
        $count = 5;
        $nbload = $nbload*$count ;

        if($request->get('loadBy') == "date" ){
            $videos360 = $videoRepository->findByDates($nbload, $count);
        }
        else{
            $videos360 = [];
            $allVideoNote = $videoRepository->findByNotes($nbload, $count);
            foreach($allVideoNote as $value){
                $idvideo = intval($value['video_id']);
                $oneVideo = $videoRepository->find($idvideo);
                array_push($videos360, $oneVideo);
            }
        }

    
        return new Response($this->twig->render('pages/loadvideo.html.twig', [
            'videos' => $videos360
        ]));
    }



}