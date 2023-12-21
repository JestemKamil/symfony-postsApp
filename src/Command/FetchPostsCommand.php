<?php
namespace App\Command;

use App\Entity\Posts;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'app:fetchPosts')]
class FetchPostsCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = HttpClient::create();
        $response = $client->request(
            'GET',
            'https://jsonplaceholder.typicode.com/posts'
        )->toArray();

        foreach ($response as $post) {
            $user = $this->entityManager->getRepository(Users::class)->find($post['userId']);
            $product = new Posts();
            $product->setUser($user);
            $product->setTitle($post['title']);
            $product->setBody($post['body']);
            $this->entityManager->persist($product);
            $this->entityManager->flush();
        }

        return Command::SUCCESS;
    }
}