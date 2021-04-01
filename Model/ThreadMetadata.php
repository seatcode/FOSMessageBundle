<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Model;

abstract class ThreadMetadata
{
    protected $participant;
    protected $isDeleted = false;

    /**
     * Date of last message written by the participant.
     *
     * @var \DateTime
     */
    protected $lastParticipantMessageDate;

    /**
     * Date of last message written by another participant.
     *
     * @var \DateTime
     */
    protected $lastMessageDate;

    /**
     * @return ParticipantInterface
     */
    public function getParticipant()
    {
        return $this->participant;
    }

    public function setParticipant(ParticipantInterface $participant): void
    {
        $this->participant = $participant;
    }

    /**
     * @return bool
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * @param bool $isDeleted
     */
    public function setIsDeleted($isDeleted): void
    {
        $this->isDeleted = (bool) $isDeleted;
    }

    /**
     * @return \DateTime
     */
    public function getLastParticipantMessageDate()
    {
        return $this->lastParticipantMessageDate;
    }

    public function setLastParticipantMessageDate(\DateTime $date): void
    {
        $this->lastParticipantMessageDate = $date;
    }

    /**
     * @return \DateTime
     */
    public function getLastMessageDate()
    {
        return $this->lastMessageDate;
    }

    public function setLastMessageDate(\DateTime $date): void
    {
        $this->lastMessageDate = $date;
    }
}
