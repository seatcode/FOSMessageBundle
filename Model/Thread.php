<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Model;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use InvalidArgumentException;

/**
 * Abstract thread model.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
abstract class Thread implements ThreadInterface
{
    protected ?int $id = null;
    protected ?string $subject = null;
    protected bool $isSpam = false;
    protected Collection | array $messages;
    protected Collection | array $metadata;
    protected Collection | array $participants;
    protected ?DateTimeInterface $createdAt = null;
    protected ?ParticipantInterface $createdBy = null;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->metadata = new ArrayCollection();
        $this->participants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedBy(): ?ParticipantInterface
    {
        return $this->createdBy;
    }

    public function setCreatedBy(ParticipantInterface $participant): void
    {
        $this->createdBy = $participant;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    public function getIsSpam(): bool
    {
        return $this->isSpam;
    }

    public function setIsSpam(bool $isSpam): void
    {
        $this->isSpam = $isSpam;
    }

    public function addMessage(MessageInterface $message): void
    {
        $this->messages->add($message);
    }

    public function getMessages(): Collection | array
    {
        return $this->messages;
    }

    public function getFirstMessage(): ?MessageInterface
    {
        return $this->getMessages()->first();
    }

    public function getLastMessage(): ?MessageInterface
    {
        return $this->getMessages()->last();
    }

    public function isDeletedByParticipant(ParticipantInterface $participant): bool
    {
        if ($meta = $this->getMetadataForParticipant($participant)) {
            return $meta->getIsDeleted();
        }

        return false;
    }

    public function setIsDeletedByParticipant(ParticipantInterface $participant, bool $isDeleted): void
    {
        if (!$meta = $this->getMetadataForParticipant($participant)) {
            throw new InvalidArgumentException(sprintf('No metadata exists for participant with id "%s"', $participant->getId()));
        }

        $meta->setIsDeleted($isDeleted);

        if ($isDeleted) {
            // also mark all thread messages as read
            foreach ($this->getMessages() as $message) {
                $message->setIsReadByParticipant($participant, true);
            }
        }
    }

    public function setIsDeleted(bool $isDeleted): void
    {
        foreach ($this->getParticipants() as $participant) {
            $this->setIsDeletedByParticipant($participant, $isDeleted);
        }
    }

    public function isReadByParticipant(ParticipantInterface $participant): bool
    {
        foreach ($this->getMessages() as $message) {
            if (!$message->isReadByParticipant($participant)) {
                return false;
            }
        }

        return true;
    }

    public function setIsReadByParticipant(ParticipantInterface $participant, bool $isRead): void
    {
        foreach ($this->getMessages() as $message) {
            $message->setIsReadByParticipant($participant, $isRead);
        }
    }

    public function addMetadata(ThreadMetadata $meta): void
    {
        $this->metadata->add($meta);
    }

    public function getMetadataForParticipant(ParticipantInterface $participant): ?ThreadMetadata
    {
        foreach ($this->metadata as $meta) {
            if ($meta->getParticipant()->getId() === $participant->getId()) {
                return $meta;
            }
        }

        return null;
    }

    public function getOtherParticipants(ParticipantInterface $participant): array
    {
        $otherParticipants = $this->getParticipants();

        $key = array_search($participant, $otherParticipants, true);

        if (false !== $key) {
            unset($otherParticipants[$key]);
        }

        // we want to reset the array indexes
        return array_values($otherParticipants);
    }
}
