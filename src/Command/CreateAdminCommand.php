<?php
namespace App\Command;

use App\Entity\Admins;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'app:createAdmin')]
class CreateAdminCommand extends Command
{
    protected static $defaultName = 'app:create-admin';

    private $passwordHasher;
    private $entityManager;

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager)
    {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Email admina')
            ->addArgument('password', InputArgument::REQUIRED, 'Hasło admina')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $admin = new Admins();
        $admin->setEmail($input->getArgument('email'));
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            $input->getArgument('password')
        );
        $admin->setPassword($hashedPassword);

        $this->entityManager->persist($admin);
        $this->entityManager->flush();

        $output->writeln('Admin created successfully.');

        return Command::SUCCESS;
    }
}
?>