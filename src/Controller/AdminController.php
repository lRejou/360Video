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
use App\Entity\Admin;
use App\Repository\AdminRepository;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(Environment $twig, UserPasswordEncoderInterface $encoder)
    {
        $this->twig = $twig;
        $this->encoder = $encoder;
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
    public function validationVideo(VideoUserRepository $videoUserRepository, VideoRepository $videoRepository): Response
    {
        $tab = explode('/', $_SERVER['REQUEST_URI']);
        $video =  $videoUserRepository->findOneBy(['id' => $tab[3]]);

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

    /**
     * @Route("/setting", name="admin_setting")
     */
    public function setting(): Response
    {

        /*if( %env(APP_ENV)% == DEV){

        }*/


        return new Response($this->twig->render('admin/setting.html.twig', ["msg" => "" , "type" => "username"]));
    }

    /**
     * @Route("/settingusername", name="admin_settingusername", methods={"POST" , "GET"})
     */
    public function settingUsername(Request $request, UserInterface $user, AdminRepository $adminRepository)
    {
        $username = $request->get('nomUtilisateur');
        $usernameconfirme = $request->get('nomUtilisateur2');
        if($username == $usernameconfirme){
            
            $userId = $user->getId();
            $admin =  $adminRepository->findOneBy(['id' => $userId]);
            $admin->setusername($username);

            $em = $this->getDoctrine()->getManager();
            $em->persist($admin);
            $em->flush();

            return $this->render('admin/settingUsername.html.twig');
        }
        else{
            return $this->render('admin/setting.html.twig' , ["msg" => "Les deux noms d'utilisateur doivent être identiques", "type" => "username"]);
        }
    }


    /**
     * @Route("/settingpassword", name="admin_settingpassword", methods={"POST" , "GET"})
     */
    public function settingPassword(Request $request, UserInterface $user, AdminRepository $adminRepository)
    {
        $password = $request->get('password');
        $passwordconfirme = $request->get('password2');
        if($password == $passwordconfirme){
            
            $userId = $user->getId();
            $admin =  $adminRepository->findOneBy(['id' => $userId]);
            $admin->setPassword($this->encoder->encodePassword($admin, $password));

            $em = $this->getDoctrine()->getManager();
            $em->persist($admin);
            $em->flush();

            return $this->render('admin/settingPassword.html.twig');
        }
        else{
            return $this->render('admin/setting.html.twig' , ["msg" => "Les deux mots de passe doivent être identiques", "type" => "password"]);
        }
    }

        /**
     * @Route("/adduser", name="admin_adduser", methods={"POST" , "GET"})
     */
    public function settingAddUser(Request $request, UserInterface $user, AdminRepository $adminRepository)
    {
        $username = $request->get('nomUtilisateur');
        $password = $request->get('password');
        $passwordconfirme = $request->get('password2');
        if($password == $passwordconfirme){
            
            $admin = new admin();
            $admin->setusername($username);
            $admin->setPassword($this->encoder->encodePassword($admin, $password));

            $em = $this->getDoctrine()->getManager();
            $em->persist($admin);
            $em->flush();

            return $this->render('admin/settingadduser.html.twig');
        }
        else{
            return $this->render('admin/setting.html.twig' , ["msg" => "Les deux mots de passe doivent être identiques", "type" => "newuser"]);
        }
    }

}