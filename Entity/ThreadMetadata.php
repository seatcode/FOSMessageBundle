<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Entity;

use FOS\MessageBundle\Model\ThreadInterface;
use FOS\MessageBundle\Model\ThreadMetadata as BaseThreadMetadata;

abstract class ThreadMetadata extends BaseThreadMetadata
{
    protected ?int $id = null;
    protected ?ThreadInterface $thread = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getThread(): ?ThreadInterface
    {
        return $this->thread;
    }

    public function setThread(ThreadInterface $thread): void
    {
        $this->thread = $thread;
    }
}
