<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Security;

use FOS\MessageBundle\Model\ParticipantInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Provides the authenticated participant.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class ParticipantProvider implements ParticipantProviderInterface
{
    public function __construct(
        protected TokenStorageInterface $tokenStorage
    ) {
    }

    public function getAuthenticatedParticipant(): ParticipantInterface
    {
        $participant = $this->tokenStorage->getToken()?->getUser();

        if (!$participant instanceof ParticipantInterface) {
            throw new AccessDeniedException('Must be logged in with a ParticipantInterface instance');
        }

        return $participant;
    }
}
