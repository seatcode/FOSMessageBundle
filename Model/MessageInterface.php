<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Model;

use DateTimeInterface;

/**
 * Message model.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
interface MessageInterface extends ReadableInterface
{
    public function getId(): int;
    public function getThread(): ThreadInterface;
    public function setThread(ThreadInterface $thread): void;
    public function getCreatedAt(): DateTimeInterface;
    public function getBody(): string;
    public function setBody(string $body): void;
    public function getSender(): ParticipantInterface;
    public function setSender(ParticipantInterface $sender): void;
}
