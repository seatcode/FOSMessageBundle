<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Event;

use FOS\MessageBundle\Model\MessageInterface;

class MessageEvent extends ThreadEvent
{
    public function __construct(
        private MessageInterface $message
    ) {
        parent::__construct($message->getThread());
    }

    public function getMessage(): MessageInterface
    {
        return $this->message;
    }
}
