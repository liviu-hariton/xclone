<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'Create a new user account',
)]
class CreateUserCommand extends Command
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'User email')
            /*->addArgument('password', InputArgument::REQUIRED, 'User password')*/
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = $input->getArgument('email');

        $user = new User();

        $user->setEmail($email);

        $helper = $this->getHelper('question');

        $question = new Question('Please enter the password for this account:');

        $question->setHidden(true);
        $question->setHiddenFallback(false);

        $password = $helper->ask($input, $output, $question);

        $user->setPassword(
            $this->userPasswordHasher->hashPassword($user, $password)
        );

        $manager = $this->getApplication()->getKernel()->getContainer()->get('doctrine')->getManager();

        $manager->persist($user);
        $manager->flush();

        $io->success(sprintf('The %s user account has been created successfully.', $email));

        return Command::SUCCESS;
    }
}
