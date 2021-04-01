<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Model;

interface ReadableInterface
{
    public function isReadByParticipant(ParticipantInterface $participant): bool;
    public function setIsReadByParticipant(ParticipantInterface $participant, bool $isRead): void;
}
