<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Provider;

use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\ThreadInterface;
use FOS\MessageBundle\ModelManager\MessageManagerInterface;
use FOS\MessageBundle\ModelManager\ThreadManagerInterface;
use FOS\MessageBundle\Reader\ReaderInterface;
use FOS\MessageBundle\Security\AuthorizerInterface;
use FOS\MessageBundle\Security\ParticipantProviderInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Provides threads for the current authenticated user.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class Provider implements ProviderInterface
{
    public function __construct(
        protected ThreadManagerInterface $threadManager,
        protected MessageManagerInterface $messageManager,
        protected ReaderInterface $threadReader,
        protected AuthorizerInterface $authorizer,
        protected ParticipantProviderInterface $participantProvider
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function getInboxThreads(): array
    {
        $participant = $this->getAuthenticatedParticipant();

        return $this->threadManager->findParticipantInboxThreads($participant);
    }

    /**
     * {@inheritdoc}
     */
    public function getSentThreads(): array
    {
        $participant = $this->getAuthenticatedParticipant();

        return $this->threadManager->findParticipantSentThreads($participant);
    }

    /**
     * {@inheritdoc}
     */
    public function getDeletedThreads(): array
    {
        $participant = $this->getAuthenticatedParticipant();

        return $this->threadManager->findParticipantDeletedThreads($participant);
    }

    /**
     * {@inheritdoc}
     */
    public function getThread(int $threadId): ThreadInterface
    {
        $thread = $this->threadManager->findThreadById($threadId);

        if (null === $thread) {
            throw new NotFoundHttpException('There is no such thread');
        }

        if (!$this->authorizer->canSeeThread($thread)) {
            throw new AccessDeniedException('You are not allowed to see this thread');
        }

        // Load the thread messages before marking them as read
        // because we want to see the unread messages
        $thread->getMessages();
        $this->threadReader->markAsRead($thread);

        return $thread;
    }

    /**
     * {@inheritdoc}
     */
    public function getNbUnreadMessages(): int
    {
        return $this->messageManager->getNbUnreadMessageByParticipant($this->getAuthenticatedParticipant());
    }

    /**
     * Gets the current authenticated user.
     *
     * @return ParticipantInterface
     */
    protected function getAuthenticatedParticipant(): ParticipantInterface
    {
        return $this->participantProvider->getAuthenticatedParticipant();
    }
}
