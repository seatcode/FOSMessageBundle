<?php

declare(strict_types=1);

namespace FOS\MessageBundle\ModelManager;

use FOS\MessageBundle\Model\MessageInterface;
use FOS\MessageBundle\Model\ParticipantInterface;

/**
 * Interface to be implemented by message managers. This adds an additional level
 * of abstraction between your application, and the actual repository.
 *
 * All changes to messages should happen through this interface.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
interface MessageManagerInterface extends ReadableManagerInterface
{
    public function getNbUnreadMessageByParticipant(ParticipantInterface $participant): int;
    public function createMessage(): MessageInterface;
    public function saveMessage(MessageInterface $message, bool $andFlush = true): void;
    public function getClass(): string;
}
