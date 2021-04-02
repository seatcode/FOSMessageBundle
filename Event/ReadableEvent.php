<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Event;

use FOS\MessageBundle\Model\ReadableInterface;
use Symfony\Contracts\EventDispatcher\Event;

class ReadableEvent extends Event
{
    public function __construct(
        private ReadableInterface $readable
    ) {
    }

    public function getReadable(): ReadableInterface
    {
        return $this->readable;
    }
}
