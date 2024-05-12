<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\DirectorRepository;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path:"/login", name:"app_login")]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path:"/logout", name:"app_logout")]
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route (path:"/profil", name:"app_profil")]
    public function profil( StudentRepository $studentRepository, DirectorRepository $directorRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        if ($user->getIsEdited() == false){
            $this->addFlash('danger', 'Vous devez d\'abord édité votre profil pour accéder à cette page');
            return $this->redirectToRoute('home_index');
        }
        $student = $studentRepository->findOneBy(['user' => $user]);
        return $this->render('security/profil.html.twig',[
            'user' =>  $user,
            'student'=> $student ?? $directorRepository->findOneBy(['user' => $user]),

        ]);
    }
}
