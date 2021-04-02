<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Entity;

use FOS\MessageBundle\Model\MessageInterface;
use FOS\MessageBundle\Model\MessageMetadata as BaseMessageMetadata;

abstract class MessageMetadata extends BaseMessageMetadata
{
    protected ?int $id = null;
    protected ?MessageInterface $message = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?MessageInterface
    {
        return $this->message;
    }

    public function setMessage(MessageInterface $message): void
    {
        $this->message = $message;
    }
}
