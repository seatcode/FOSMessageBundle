<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\MessageBundle\Model\MessageInterface;
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\Thread as BaseThread;
use FOS\MessageBundle\Model\ThreadMetadata as ModelThreadMetadata;

abstract class Thread extends BaseThread
{
    /**
     * Messages contained in this thread.
     *
     * @var Collection|MessageInterface[]
     */
    protected Collection | array $messages;

    /**
     * Users participating in this conversation.
     *
     * @var Collection|ParticipantInterface[]
     */
    protected Collection | array $participants;

    /**
     * Thread metadata.
     *
     * @var Collection|ModelThreadMetadata[]
     */
    protected Collection | array $metadata;

    /**
     * All text contained in the thread messages
     * Used for the full text search.
     */
    protected string $keywords = '';

    /**
     * Participant that created the thread.
     */
    protected ParticipantInterface $createdBy;

    /**
     * Date this thread was created at.
     */
    protected DateTimeInterface $createdAt;

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
     * @param array|\Traversable
     *
     * @throws \InvalidArgumentException
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
