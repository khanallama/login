<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class UserprofileController extends AbstractController
{
    public function __construct(private Security $security)
        {
         
        }

    #[Route('/user/userprofile', name: 'app_userprofile')]
     public function index()
      {

        // $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $user = $this->security->getUser();

    
        // $user = $this->getUser();

        // dd($user->getRoles());
        

       
        return $this->render('userprofile/index.html.twig', [
            'user' => $user,
        ]);

        

    
      }


      #[Route('/user/user', name: 'app_user')]
      public function testing()
       {
 
    dd('hello');
         // $this->denyAccessUnlessGranted('ROLE_ADMIN');
         $user = $this->security->getUser();
         
 
        
        //  return $this->render('userprofile/index.html.twig', [
        //      'user' => $user,
        //  ]);

       }
}
