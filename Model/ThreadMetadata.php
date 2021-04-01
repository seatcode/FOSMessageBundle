<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Model;

use DateTimeInterface;

abstract class ThreadMetadata
{
    protected ParticipantInterface $participant;
    protected bool $isDeleted = false;
    protected DateTimeInterface $lastParticipantMessageDate;
    protected DateTimeInterface $lastMessageDate;

    public function getParticipant(): ParticipantInterface
    {
        return $this->participant;
    }

    public function setParticipant(ParticipantInterface $participant): void
    {
        $this->participant = $participant;
    }

    public function getIsDeleted(): bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): void
    {
        $this->isDeleted = $isDeleted;
    }

    public function getLastParticipantMessageDate(): DateTimeInterface
    {
        return $this->lastParticipantMessageDate;
    }

    public function setLastParticipantMessageDate(DateTimeInterface $date): void
    {
        $this->lastParticipantMessageDate = $date;
    }

    public function getLastMessageDate(): DateTimeInterface
    {
        return $this->lastMessageDate;
    }

    public function setLastMessageDate(DateTimeInterface $date): void
    {
        $this->lastMessageDate = $date;
    }
}
