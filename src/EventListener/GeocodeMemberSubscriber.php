<?php

namespace App\EventListener;

use App\Entity\Member;
use App\Service\GeocoderService;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;

class GeocodeMemberSubscriber
{
    protected $geocoderService;

    protected $logger;

    public function __construct(GeocoderService $geocoderService, LoggerInterface $logger)
    {
        $this->geocoderService = $geocoderService;
        $this->logger = $logger;
    }

    public function preUpdate(Member $member, PreUpdateEventArgs $eventArgs)
    {
        if ($eventArgs->hasChangedField('mailingAddressLine1')
            || $eventArgs->hasChangedField('mailingAddressLine2')
            || $eventArgs->hasChangedField('mailingCity')
            || $eventArgs->hasChangedField('mailingState')
            || $eventArgs->hasChangedField('mailingPostalCode')
            || $eventArgs->hasChangedField('mailingCountry')
        ) {
            // Clear existing coordinates on save
            $member->setMailingLatitude(null);
            $member->setMailingLongitude(null);
            if ($member->getMailingAddressLine1() || $member->getMailingAddressLine2()) {
                try {
                    $this->geocoderService->geocodeMemberMailingAddress($member);
                } catch (\Exception $e) {
                    $this->logger->error($e->getMessage());
                }
            }
        }
    }

    public function prePersist(Member $member, LifecycleEventArgs $eventArgs)
    {
        if ($member->getMailingAddressLine1()
            || $member->getMailingAddressLine2()
            || $member->getMailingCity()
            || $member->getMailingState()
            || $member->getMailingPostalCode()
            || $member->getMailingcountry()
        ) {
            // Do not call service if the created record includes coordinates
            if (!$member->getMailingLatitude() && !$member->getMailingLongitude()) {
                try {
                    $this->geocoderService->geocodeMemberMailingAddress($member);
                } catch (\Exception $e) {
                    $this->logger->error($e->getMessage());
                }
            }
        }
    }
}
