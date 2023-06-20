<?php

namespace App\Command;

use App\Service\PhoneService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsCommand(name: 'app:phone:webhook')]
class PhoneWebhookCommand extends Command
{
    protected $phoneService;

    protected $urlGenerator;

    public function __construct(PhoneService $phoneService, UrlGeneratorInterface $urlGenerator)
    {
        parent::__construct();
        $this->phoneService = $phoneService;
        $this->urlGenerator = $urlGenerator;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Get webhook URL and token for Phone integration.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if (!$this->phoneService->isConfigured()) {
            $io->error('Phone Service not configured.');

            return Command::FAILURE;
        }

        $io->info(sprintf(
            "Your Phone webhook token is:\n\n    %s\n\nYour webhook URL is:\n\n    %s",
            $this->phoneService->getWebhookToken(),
            $this->urlGenerator->generate(
                'webhook_phone_service',
                [
                    'token' => $this->phoneService->getWebhookToken(),
                ],
                UrlGeneratorInterface::ABSOLUTE_URL
            ))
        );

        return Command::SUCCESS;
    }
}
