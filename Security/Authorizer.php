<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Security;

use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\ThreadInterface;

/**
 * Manages permissions to manipulate threads and messages.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class Authorizer implements AuthorizerInterface
{
    public function __construct(
        protected ParticipantProviderInterface $participantProvider
    ) {
    }

    public function canSeeThread(ThreadInterface $thread): bool
    {
        return $this->getAuthenticatedParticipant() && $thread->isParticipant($this->getAuthenticatedParticipant());
    }

    public function canDeleteThread(ThreadInterface $thread): bool
    {
        return $this->canSeeThread($thread);
    }

    public function canMessageParticipant(ParticipantInterface $participant): bool
    {
        return true;
    }

    protected function getAuthenticatedParticipant(): ParticipantInterface
    {
        return $this->participantProvider->getAuthenticatedParticipant();
    }
}
