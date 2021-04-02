<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Event;

use FOS\MessageBundle\Model\ThreadInterface;
use Symfony\Contracts\EventDispatcher\Event;

class ThreadEvent extends Event
{
    public function __construct(
        private ThreadInterface $thread
    ) {
    }

    public function getThread(): ThreadInterface
    {
        return $this->thread;
    }
}
