<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Tests\Functional\EntityManager;

use FOS\MessageBundle\Model\MessageInterface;
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\ReadableInterface;
use FOS\MessageBundle\Model\ThreadInterface;
use FOS\MessageBundle\ModelManager\MessageManager as BaseMessageManager;
use FOS\MessageBundle\Tests\Functional\Entity\Message;

/**
 * Default ORM MessageManager.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class MessageManager extends BaseMessageManager
{
    public function getNbUnreadMessageByParticipant(ParticipantInterface $participant): int
    {
        return 3;
    }

    public function markAsReadByParticipant(ReadableInterface $readable, ParticipantInterface $participant): void
    {
    }

    public function markAsUnreadByParticipant(ReadableInterface $readable, ParticipantInterface $participant): void
    {
    }

    public function markIsReadByThreadAndParticipant(ThreadInterface $thread, ParticipantInterface $participant, bool $isRead): void
    {
    }

    protected function markIsReadByParticipant(MessageInterface $message, ParticipantInterface $participant, bool $isRead): void
    {
    }

    public function saveMessage(MessageInterface $message, bool $andFlush = true): void
    {
    }

    public function getClass(): string
    {
        return Message::class;
    }
}
