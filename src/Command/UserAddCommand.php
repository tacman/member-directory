<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;

class UserAddCommand extends Command
{
    protected static $defaultName = 'app:user:add';

    protected $passwordEncode;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }


    protected function configure()
    {
        $this
            ->setDescription('Adds a user to the system.')
            ->addArgument('email', InputArgument::REQUIRED, 'Email address of the user')
            ->addOption('roles', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'Roles')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $roles = $input->getOption('roles');

        if ($email) {
            $io->note(sprintf('Adding user: %s', $email));
        }

        $helper = $this->getHelper('question');

        $question = new Question('Enter the user\'s password:');
        $question->setHidden(true);
        $question->setHiddenFallback(false);

        $password = $helper->ask($input, $output, $question);

        $question = new Question('Confirm the user\'s password:');
        $question->setHidden(true);
        $question->setHiddenFallback(false);

        $password_confirm = $helper->ask($input, $output, $question);

        if (!$password || $password != $password_confirm) {
            $io->error('Passwords did not match, or were blank.');
            return 1;
        }

        // Add user to the database
        $user = new User();
        $user->setEmail($email);
        if ($input->getOption('roles') && count($roles)) {
            $user->setRoles($roles);
        }
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            $password
        ));
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success(sprintf('You have added %s to the system as ID %d.', $user->getEmail(), $user->getId()));
    }
}
