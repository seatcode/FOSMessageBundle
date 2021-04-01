<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Security;

use FOS\MessageBundle\Model\ParticipantInterface;

/**
 * Provides the authenticated participant.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
interface ParticipantProviderInterface
{
    public function getAuthenticatedParticipant(): ParticipantInterface;
}
