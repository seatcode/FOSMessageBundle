<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Sender;

use FOS\MessageBundle\Model\MessageInterface;

/**
 * Sends messages.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
interface SenderInterface
{
    /**
     * Sends the given message.
     */
    public function send(MessageInterface $message);
}
