<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class LikeController extends AbstractController
{
    #[Route('/like/{id}', name: 'app_like')]
    #[isGranted('IS_AUTHENTICATED_FULLY')]
    public function like(MicroPost $post, EntityManagerInterface $entityManager, Request $request): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        $post->addLikedBy($currentUser);

        $entityManager->persist($post);
        $entityManager->flush();

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/unlike/{id}', name: 'app_unlike')]
    #[isGranted('IS_AUTHENTICATED_FULLY')]
    public function unlike(MicroPost $post, EntityManagerInterface $entityManager, Request $request): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        $post->removeLikedBy($currentUser);

        $entityManager->persist($post);
        $entityManager->flush();

        return $this->redirect($request->headers->get('referer'));
    }
}
