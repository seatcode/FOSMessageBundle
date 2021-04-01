<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Entity;

use Doctrine\Common\Collections\Collection;
use FOS\MessageBundle\Model\Message as BaseMessage;
use FOS\MessageBundle\Model\MessageMetadata as ModelMessageMetadata;

abstract class Message extends BaseMessage
{
    /**
     * Get the collection of MessageMetadata.
     *
     * @return Collection
     */
    public function getAllMetadata()
    {
        return $this->metadata;
    }

    /**
     * {@inheritdoc}
     */
    public function addMetadata(ModelMessageMetadata $meta): void
    {
        $meta->setMessage($this);
        parent::addMetadata($meta);
    }
}
