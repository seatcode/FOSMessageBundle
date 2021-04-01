<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Tests\Functional\EntityManager;

use Doctrine\ORM\QueryBuilder;
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\ReadableInterface;
use FOS\MessageBundle\Model\ThreadInterface;
use FOS\MessageBundle\ModelManager\ThreadManager as BaseThreadManager;
use FOS\MessageBundle\Tests\Functional\Entity\Thread;

class ThreadManager extends BaseThreadManager
{
    public function findThreadById(int $id): ?ThreadInterface
    {
        return new Thread();
    }

    public function getParticipantInboxThreadsQueryBuilder(ParticipantInterface $participant): QueryBuilder
    {
    }

    public function findParticipantInboxThreads(ParticipantInterface $participant): array
    {
        return [new Thread()];
    }

    public function getParticipantSentThreadsQueryBuilder(ParticipantInterface $participant): QueryBuilder
    {
    }

    public function findParticipantSentThreads(ParticipantInterface $participant): array
    {
        return [];
    }

    public function getParticipantDeletedThreadsQueryBuilder(ParticipantInterface $participant): QueryBuilder
    {
    }

    public function findParticipantDeletedThreads(ParticipantInterface $participant): array
    {
        return [];
    }

    public function getParticipantThreadsBySearchQueryBuilder(ParticipantInterface $participant, $search): QueryBuilder
    {
    }

    public function findParticipantThreadsBySearch(ParticipantInterface $participant, $search): array
    {
        return [];
    }

    public function findThreadsCreatedBy(ParticipantInterface $participant): array
    {
        return [];
    }

    public function markAsReadByParticipant(ReadableInterface $readable, ParticipantInterface $participant): void
    {
    }

    public function markAsUnreadByParticipant(ReadableInterface $readable, ParticipantInterface $participant): void
    {
    }

    public function saveThread(ThreadInterface $thread, $andFlush = true): void
    {
    }

    public function deleteThread(ThreadInterface $thread): void
    {
    }

    public function getClass(): string
    {
        return Thread::class;
    }
}
