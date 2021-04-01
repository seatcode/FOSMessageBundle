<?php

declare(strict_types=1);

namespace FOS\MessageBundle\ModelManager;

use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\ReadableInterface;

/**
 * Capable of updating the read state of objects directly in the storage,
 * without modifying the state of the object.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
interface ReadableManagerInterface
{
    /**
     * Marks the readable as read by this participant
     * Must be applied directly to the storage,
     * without modifying the readable state.
     * We want to show the unread readables on the page,
     * as well as marking them as read.
     */
    public function markAsReadByParticipant(ReadableInterface $readable, ParticipantInterface $user): void;

    /**
     * Marks the readable as unread by this participant.
     */
    public function markAsUnreadByParticipant(ReadableInterface $readable, ParticipantInterface $user): void;
}
