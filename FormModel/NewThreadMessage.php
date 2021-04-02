<?php

declare(strict_types=1);

namespace FOS\MessageBundle\FormModel;

use FOS\MessageBundle\Model\ParticipantInterface;

class NewThreadMessage extends AbstractMessage
{
    protected ?ParticipantInterface $recipient = null;
    protected ?string $subject = null;

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    public function getRecipient(): ?ParticipantInterface
    {
        return $this->recipient;
    }

    public function setRecipient(ParticipantInterface $recipient): void
    {
        $this->recipient = $recipient;
    }
}
