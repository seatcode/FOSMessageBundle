<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Model;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Abstract message model.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
abstract class Message implements MessageInterface
{
    protected int $id;
    protected ParticipantInterface $sender;
    protected string $body;
    protected DateTimeInterface $createdAt;
    protected ThreadInterface $thread;
    protected Collection | array $metadata;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->metadata = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getThread(): ThreadInterface
    {
        return $this->thread;
    }

    public function setThread(ThreadInterface $thread): void
    {
        $this->thread = $thread;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function getSender(): ParticipantInterface
    {
        return $this->sender;
    }

    public function setSender(ParticipantInterface $sender): void
    {
        $this->sender = $sender;
    }

    public function getTimestamp(): int
    {
        return $this->getCreatedAt()->getTimestamp();
    }

    public function addMetadata(MessageMetadata $meta): void
    {
        $this->metadata->add($meta);
    }

    public function getMetadataForParticipant(ParticipantInterface $participant): ?MessageMetadata
    {
        foreach ($this->metadata as $meta) {
            if ($meta->getParticipant()->getId() === $participant->getId()) {
                return $meta;
            }
        }

        return null;
    }

    public function isReadByParticipant(ParticipantInterface $participant): bool
    {
        if ($meta = $this->getMetadataForParticipant($participant)) {
            return $meta->getIsRead();
        }

        return false;
    }

    public function setIsReadByParticipant(ParticipantInterface $participant, bool $isRead): void
    {
        if (!$meta = $this->getMetadataForParticipant($participant)) {
            throw new \InvalidArgumentException(sprintf('No metadata exists for participant with id "%s"', $participant->getId()));
        }

        $meta->setIsRead($isRead);
    }
}
