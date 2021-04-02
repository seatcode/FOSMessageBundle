<?php

declare(strict_types=1);

namespace FOS\MessageBundle\FormModel;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\MessageBundle\Model\ParticipantInterface;

/**
 * Class for handling multiple recipients in thread.
 */
class NewThreadMultipleMessage extends AbstractMessage
{
    protected Collection $recipients;
    protected ?string $subject;

    public function __construct()
    {
        $this->recipients = new ArrayCollection();
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    public function getRecipients(): Collection
    {
        return $this->recipients;
    }

    public function addRecipient(ParticipantInterface $recipient): void
    {
        if (!$this->recipients->contains($recipient)) {
            $this->recipients->add($recipient);
        }
    }

    public function removeRecipient(ParticipantInterface $recipient): void
    {
        $this->recipients->removeElement($recipient);
    }
}
