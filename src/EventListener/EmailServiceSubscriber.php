<?php

namespace App\EventListener;

use App\Entity\Member;
use App\Service\EmailService;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class EmailServiceSubscriber
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function preUpdate(Member $member, PreUpdateEventArgs $eventArgs)
    {
        if (!$this->emailService->isConfigured()) {
            return;
        }
        // If set to 'Do Not Contact', unsubscribe the user
        if ($eventArgs->hasChangedField('isLocalDoNotContact') && $member->getIsLocalDoNotContact()) {
            $this->emailService->unsubscribeMember($member);

            return;
        }
        // If new Member Status is listed as inactive, delete the user user's subscription
        if ($eventArgs->hasChangedField('status') && $member->getStatus()->getIsInactive()) {
            $this->emailService->deleteMember($member->getPrimaryEmail());

            return;
        }
        // If member is now deceased, unsubscribe
        if ($eventArgs->hasChangedField('isDeceased') && $member->getIsDeceased()) {
            $this->emailService->unsubscribeMember($member);

            return;
        }
        // If email was previously set and has been changed, update email address in ESP
        if ($eventArgs->hasChangedField('primaryEmail')
            && $eventArgs->getOldValue('primaryEmail')
            && $eventArgs->getNewValue('primaryEmail')
        ) {
            $this->emailService->updateMember(
                $eventArgs->getOldValue('primaryEmail'),
                $member
            );
            // Re-subscribe user if old address was on supression list
            $this->emailService->subscribeMember($member, true);

            return;
        }
        // If email was removed from record, delete previous record in ESP
        if ($eventArgs->hasChangedField('primaryEmail')
            && $eventArgs->getOldValue('primaryEmail')
            && !$eventArgs->getNewValue('primaryEmail')
        ) {
            $this->emailService->deleteMember(
                $eventArgs->getOldValue('primaryEmail')
            );

            return;
        }
        // If email added to a record, subscribe in ESP
        if ($eventArgs->hasChangedField('primaryEmail')
            && !$eventArgs->getOldValue('primaryEmail')
            && $eventArgs->getNewValue('primaryEmail')
        ) {
            $this->emailService->subscribeMember($member);

            return;
        }
        // Update Member Record in ESP, if email exists
        if ($member->getPrimaryEmail()) {
            $this->emailService->updateMember(
                $member->getPrimaryEmail(),
                $member
            );
        }
    }

    public function prePersist(Member $member, LifecycleEventArgs $eventArgs)
    {
        if (!$this->emailService->isConfigured()
            || $member->getStatus()->getIsInactive()
        ) {
            return;
        }
        // Auto subscribe added members
        if ($member->getPrimaryEmail()) {
            $this->emailService->subscribeMember($member);
        }
    }
}
