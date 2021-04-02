<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Twig\Extension;

use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\ReadableInterface;
use FOS\MessageBundle\Model\ThreadInterface;
use FOS\MessageBundle\Provider\ProviderInterface;
use FOS\MessageBundle\Security\AuthorizerInterface;
use FOS\MessageBundle\Security\ParticipantProviderInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MessageExtension extends AbstractExtension
{
    protected ?int $nbUnreadMessagesCache = null;

    public function __construct(
        protected ParticipantProviderInterface $participantProvider,
        protected ProviderInterface $provider,
        protected AuthorizerInterface $authorizer
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('fos_message_is_read', [$this, 'isRead']),
            new TwigFunction('fos_message_nb_unread', [$this, 'getNbUnread']),
            new TwigFunction('fos_message_can_delete_thread', [$this, 'canDeleteThread']),
            new TwigFunction('fos_message_deleted_by_participant', [$this, 'isThreadDeletedByParticipant']),
        ];
    }

    public function isRead(ReadableInterface $readable): bool
    {
        return $readable->isReadByParticipant($this->getAuthenticatedParticipant());
    }

    public function canDeleteThread(ThreadInterface $thread): bool
    {
        return $this->authorizer->canDeleteThread($thread);
    }

    public function isThreadDeletedByParticipant(ThreadInterface $thread): bool
    {
        return $thread->isDeletedByParticipant($this->getAuthenticatedParticipant());
    }

    public function getNbUnread(): int
    {
        if (null === $this->nbUnreadMessagesCache) {
            $this->nbUnreadMessagesCache = $this->provider->getNbUnreadMessages();
        }

        return $this->nbUnreadMessagesCache;
    }

    protected function getAuthenticatedParticipant(): ParticipantInterface
    {
        return $this->participantProvider->getAuthenticatedParticipant();
    }
}
