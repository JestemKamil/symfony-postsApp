<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\Posts;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;


class PostsController extends AbstractController
{
    #[Route('/posts', name: 'app_posts', methods: ['GET'])]
    public function getPosts(EntityManagerInterface $entity): JsonResponse
    {
        $posts = $entity->getRepository(Posts::class)->findAll();
        $data = [];
        foreach ($posts as $post) {
            $data[] = [
                'id' => $post->getId(),
                'first_name' => $post->getUser()->getFirstName(),
                'last_name' => $post->getUser()->getLastName(),
                'title' => $post->getTitle(),
                'body' => $post->getBody()
            ];
        }
        return $this->json($data);
    }
}
