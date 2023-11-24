<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\MicroPost;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Repository\MicroPostRepository;
use App\Repository\UserProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    /*#[Route('/', name: 'app_index')]*/
    public function index(
        UserProfileRepository $profiles,
        MicroPostRepository $posts,
        EntityManagerInterface $entityManager
    ): Response
    {
        /*$user = new User();
        $user->setEmail('email@email.com');
        $user->setPassword('password');

        $profile = new UserProfile();
        $profile->setUser($user);

        $entityManager->persist($profile);
        $entityManager->flush();*/

        /*$profile = $profiles->find(1);

        $entityManager->remove($profile);
        $entityManager->flush();*/

        /*$post = $posts->find(1);

        dd($post->getComments()->count());*/

        /*$comment = new Comment();
        $comment->setPost($post);
        $comment->setText('Hello');

        $entityManager->persist($comment);
        $entityManager->flush();*/

        return $this->render('hello/index.html.twig', [
            'controller_name' => 'HelloController',
        ]);
    }
}
