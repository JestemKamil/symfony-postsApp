<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Posts;
use Doctrine\ORM\EntityManagerInterface;

class ListController extends AbstractController
{
    #[Route('/list', name: 'app_list')]
    public function index(EntityManagerInterface $entity): Response
    {

        //if request got param "id" then delete post with this id
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $post = $entity->getRepository(Posts::class)->find($id);
            $entity->remove($post);
            $entity->flush();
        }

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

        return $this->render('list/index.html.twig', [
            'data' => $data,
        ]);
    }
}
