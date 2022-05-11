<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\Events;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Security;

class UniqueUsername implements EventSubscriberInterface
{
    public function __construct(private UserRepository $repository ,private Security $security)
    {
     
    
    }
    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
        ];
    }

    public function prePersist(LifecycleEventArgs $persist): void
    {
        

        $entity = $persist->getObject();
       

         $authenticatedUser = $this->security->getUser();

        if (!$entity instanceof User) {
            return;
        } 
        $userName  = $this->getUniqueUserName();
        $entity->setUsername($userName);
        $entity->setCreatedBy($authenticatedUser);

    }

    private function getUniqueUserName()
    {
        $username =substr(str_shuffle(uniqid()) , 0,5);

        $status = $this->repository->findOneBy(['username' =>  $username]);
        if ($status) {
            $this->getUniqueUserName();
        }

        return $username;
    }
}
