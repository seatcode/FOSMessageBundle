<?php

declare(strict_types=1);

namespace FOS\MessageBundle\MessageBuilder;

use Doctrine\Common\Collections\Collection;
use FOS\MessageBundle\Model\ParticipantInterface;

/**
 * Fluent interface message builder for new thread messages.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class NewThreadMessageBuilder extends AbstractMessageBuilder
{
    public function setSubject(string $subject): static
    {
        $this->thread->setSubject($subject);

        return $this;
    }

    public function addRecipient(ParticipantInterface $recipient): static
    {
        $this->thread->addParticipant($recipient);

        return $this;
    }

    public function addRecipients(Collection $recipients): static
    {
        foreach ($recipients as $recipient) {
            $this->addRecipient($recipient);
        }

        return $this;
    }
}
