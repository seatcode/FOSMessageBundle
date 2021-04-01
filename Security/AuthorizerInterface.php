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
interface AuthorizerInterface
{
    /**
     * Tells if the current user is allowed
     * to see this thread.
     *
     * @return bool
     */
    public function canSeeThread(ThreadInterface $thread);

    /**
     * Tells if the current participant is allowed
     * to delete this thread.
     *
     * @return bool
     */
    public function canDeleteThread(ThreadInterface $thread);

    /**
     * Tells if the current participant is allowed
     * to send a message to this other participant.
     *
     * @param ParticipantInterface $participant the one we want to send a message to
     *
     * @return bool
     */
    public function canMessageParticipant(ParticipantInterface $participant);
}
