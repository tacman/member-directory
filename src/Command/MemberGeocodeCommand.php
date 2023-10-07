<?php

namespace App\Command;

use App\Entity\Member;
use App\Service\GeocoderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(name: 'app:member:geocode')]
class MemberGeocodeCommand extends Command
{
    protected $entityManager;

    protected $validator;

    protected $geocoderService;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator, GeocoderService $geocoderService)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->geocoderService = $geocoderService;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Geocode a member\'s address')
            ->addArgument('localIdentifier', InputArgument::REQUIRED, 'Local Identifier for member.')
            ->addOption('save', null, InputOption::VALUE_NONE, 'Save the result to the Member Record.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $localIdentifier = $input->getArgument('localIdentifier');

        $member = $this->entityManager->getRepository(Member::class)->findOneBy([
            'localIdentifier' => $localIdentifier,
        ]);
        if (is_null($member)) {
            $io->error('Member not found matching Local Identifier: '.$localIdentifier);

            return Command::FAILURE;
        }

        // Clear existing coordinates
        $member->setMailingLatitude(null);
        $member->setMailingLongitude(null);

        try {
            $io->title($member->getDisplayName());
            $io->writeln('<options=bold>Address Line 1:</>  '.$member->getMailingAddressLine1());
            $io->writeln('<options=bold>Address Line 2:</>  '.$member->getMailingAddressLine2());
            $io->writeln('<options=bold>City:</>            '.$member->getMailingCity());
            $io->writeln('<options=bold>State:</>           '.$member->getMailingState());
            $io->writeln('<options=bold>Postal Code:</>     '.$member->getMailingPostalCode());
            $io->writeln('');
            $this->geocoderService->geocodeMemberMailingAddress($member);
            $io->writeln('<options=bold>Source:</>          '.$this->geocoderService->getSource());
            $io->writeln('<options=bold>Latitude:</>        '.$member->getMailingLatitude());
            $io->writeln('<options=bold>Longitude:</>       '.$member->getMailingLongitude());
        } catch (\Exception $e) {
            $io->error($e->getMessage());

            return Command::FAILURE;
        }

        if ($input->getOption('save')) {
            $this->entityManager->persist($member);
            $this->entityManager->flush();
        }

        $io->success('Done!');

        return Command::SUCCESS;
    }
}
