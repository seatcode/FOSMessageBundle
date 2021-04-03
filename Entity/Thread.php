<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\Thread as BaseThread;
use FOS\MessageBundle\Model\ThreadMetadata as ModelThreadMetadata;
use InvalidArgumentException;
use Traversable;

abstract class Thread extends BaseThread
{
    /**
     * All text contained in the thread messages
     * Used for the full text search.
     */
    protected string $keywords = '';

    public function getParticipants(): Collection | array
    {
        return $this->getParticipantsCollection()->toArray();
    }

    /**
     * Gets the users participating in this conversation.
     *
     * Since the ORM schema does not map the participants collection field, it
     * must be created on demand.
     *
     * @return ArrayCollection|ParticipantInterface[]
     */
    protected function getParticipantsCollection(): Collection | array
    {
        if (null === $this->participants) {
            $this->participants = new ArrayCollection();

            foreach ($this->metadata as $data) {
                $this->participants->add($data->getParticipant());
            }
        }

        return $this->participants;
    }

    public function addParticipant(ParticipantInterface $participant): void
    {
        if (!$this->isParticipant($participant)) {
            $this->getParticipantsCollection()->add($participant);
        }
    }

    /**
     * Adds many participants to the thread.
     *
     * @param array|Traversable
     *
     * @throws InvalidArgumentException
     *
     * @return Thread
     */
    public function addParticipants(iterable $participants): static
    {
        foreach ($participants as $participant) {
            $this->addParticipant($participant);
        }

        return $this;
    }

    public function isParticipant(ParticipantInterface $participant): bool
    {
        return $this->getParticipantsCollection()->contains($participant);
    }

    /**
     * Get the collection of ModelThreadMetadata.
     *
     * @return Collection
     */
    public function getAllMetadata(): array | Collection
    {
        return $this->metadata;
    }

    public function addMetadata(ModelThreadMetadata $meta): void
    {
        $meta->setThread($this);

        parent::addMetadata($meta);
    }
}
