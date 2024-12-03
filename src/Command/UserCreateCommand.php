<?php

namespace App\Command;

use App\Service\UserService;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'user:create',
    description: 'Команда создания пользователя',
)]
class UserCreateCommand extends Command
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
        private readonly UserService $userService,
        private readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Создает нового пользователя');
        $this->addOption(name: 'password', mode: InputOption::VALUE_REQUIRED, description: 'user password');
        $this->addOption(name: 'login', mode: InputOption::VALUE_OPTIONAL, description: 'user login', );
        $this->addOption(name: 'roles', mode: InputOption::VALUE_OPTIONAL|InputOption::VALUE_IS_ARRAY, description: 'user role', default: []);
        $this->addOption(name: 'description', mode: InputOption::VALUE_OPTIONAL, description: 'description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $password = $input->getOption('password');

        try {
            $user = $this->userService->create(
                login: $input->getOption('login'),
                roles: $input->getOption('roles'),
                description: $input->getOption('description'),
            );

            $user->setPassword($this->hasher->hashPassword(user: $user, plainPassword: $password));

            $this->entityManager->flush();
        } catch (UniqueConstraintViolationException $exception) {
            $io->error('Пользователь с таким логином уже существует');

            return Command::INVALID;
        }

        $io->success(
            sprintf(
                'Создан пользователь: '.PHP_EOL.'login: %s'.PHP_EOL.'password: %s',
                $user->getLogin(),
                $password,
            ),
        );

        return Command::SUCCESS;
    }
}
