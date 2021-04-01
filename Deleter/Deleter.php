<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Deleter;

use FOS\MessageBundle\Event\FOSMessageEvents;
use FOS\MessageBundle\Event\ThreadEvent;
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\ThreadInterface;
use FOS\MessageBundle\Security\AuthorizerInterface;
use FOS\MessageBundle\Security\ParticipantProviderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Marks threads as deleted.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
final class Deleter implements DeleterInterface
{
    public function __construct(
        private AuthorizerInterface $authorizer,
        private ParticipantProviderInterface $participantProvider,
        private EventDispatcherInterface $dispatcher
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function markAsDeleted(ThreadInterface $thread): void
    {
        if (!$this->authorizer->canDeleteThread($thread)) {
            throw new AccessDeniedException('You are not allowed to delete this thread');
        }

        $thread->setIsDeletedByParticipant($this->getAuthenticatedParticipant(), true);

        $this->dispatcher->dispatch(new ThreadEvent($thread), FOSMessageEvents::POST_DELETE);
    }

    /**
     * {@inheritdoc}
     */
    public function markAsUndeleted(ThreadInterface $thread): void
    {
        if (!$this->authorizer->canDeleteThread($thread)) {
            throw new AccessDeniedException('You are not allowed to delete this thread');
        }

        $thread->setIsDeletedByParticipant($this->getAuthenticatedParticipant(), false);

        $this->dispatcher->dispatch(new ThreadEvent($thread), FOSMessageEvents::POST_UNDELETE);
    }

    private function getAuthenticatedParticipant(): ParticipantInterface
    {
        return $this->participantProvider->getAuthenticatedParticipant();
    }
}
