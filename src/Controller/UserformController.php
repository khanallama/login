<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Loader\Configurator\AliasConfigurator;

#[Route('/user')]

class UserformController extends AbstractController
{
    public function __construct(private UserRepository $repository)
    {
    }
    #[Route('/', name: 'userform')]
    public function index(): Response
    {
        return $this->render('userform/index.html.twig');
    }

    #[Route('/create', name: 'create', methods: 'POST')]
    public function create(ManagerRegistry $doctrine, Request $request): Response
    {
        $firstName = ucwords($request->request->get('firstname'));
        $lastName  = ucwords($request->request->get('lastname'));
        $phone     = $request->request->get('phone');
        $email     = $request->request->get('email');

        $entityManager = $doctrine->getManager();
        $user = new User();
        $user->setFirstname($firstName);
        $user->setLastname($lastName);
        $user->setEmail($email);
        $user->setPhone($phone);

        // $loginUser = $this->getUser();
        // $user->setCreatedBy($loginUser);

        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('fetch');
    }



    #[Route('/fetch', name: 'fetch')]
    public function fetch(): Response
    {
        $users = $this->repository->findAll();
        foreach ($users as $user) {
            $phoneNumber =  $user->getPhone();
            $maskedPhone = $this->getMaskPhone($phoneNumber);
            // dd($maskedPhone);
            $user->setPhone($maskedPhone);
        }

        return $this->render('UserData/userdata.html.twig', [
            'users' => $users,

        ]);
    }

    // private function getUniqueUserName()
    // {
    //     $userName =substr(str_shuffle(uniqid()) , 0,5);

    //     $status = $this->repository->findOneBy(['username' => $userName]);
    //     if ($status) {
    //         $this->getUniqueUserName();
    //     }

    //     return $userName;
    // }



    private function getMaskPhone($number)
    {
        $length = strlen($number);
        $maskedPhone = str_repeat('*',$length - 4) . substr($number, -4);
        return $maskedPhone;
    }
}
