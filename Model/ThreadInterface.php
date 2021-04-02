<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Model;

use DateTimeInterface;
use Doctrine\Common\Collections\Collection;

interface ThreadInterface extends ReadableInterface
{
    public function getId(): ?int;
    public function getSubject(): ?string;
    public function setSubject(string $subject): void;
    public function getMessages(): Collection | array;
    public function addMessage(MessageInterface $message): void;
    public function getFirstMessage(): ?MessageInterface;
    public function getLastMessage(): ?MessageInterface;
    public function getCreatedBy(): ?ParticipantInterface;
    public function setCreatedBy(ParticipantInterface $participant): void;
    public function getCreatedAt(): ?DateTimeInterface;
    public function setCreatedAt(DateTimeInterface $createdAt): void;
    public function getParticipants(): Collection | array;
    public function isParticipant(ParticipantInterface $participant): bool;
    public function addParticipant(ParticipantInterface $participant): void;
    public function isDeletedByParticipant(ParticipantInterface $participant): bool;
    public function setIsDeletedByParticipant(ParticipantInterface $participant, bool $isDeleted): void;
    public function setIsDeleted(bool $isDeleted): void;
    public function getOtherParticipants(ParticipantInterface $participant): array;
}
