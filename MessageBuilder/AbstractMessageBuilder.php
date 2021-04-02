<?php

declare(strict_types=1);

namespace FOS\MessageBundle\MessageBuilder;

use FOS\MessageBundle\Model\MessageInterface;
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\ThreadInterface;

/**
 * Fluent interface message builder.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
abstract class AbstractMessageBuilder
{
    public function __construct(
        protected MessageInterface $message,
        protected ThreadInterface $thread
    ) {
        $this->message->setThread($this->thread);
        $this->thread->addMessage($message);
    }

    /**
     * Gets the created message.
     *
     * @return MessageInterface the message created
     */
    public function getMessage(): MessageInterface
    {
        return $this->message;
    }

    public function setBody(string $body): static
    {
        $this->message->setBody($body);

        return $this;
    }

    public function setSender(ParticipantInterface $sender): static
    {
        $this->message->setSender($sender);
        $this->thread->addParticipant($sender);

        return $this;
    }
}
