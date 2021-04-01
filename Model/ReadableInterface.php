<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Model;

interface ReadableInterface
{
    /**
     * Tells if this is read by this participant.
     *
     * @return bool
     */
    public function isReadByParticipant(ParticipantInterface $participant);

    /**
     * Sets whether or not this participant has read this.
     *
     * @param bool $isRead
     */
    public function setIsReadByParticipant(ParticipantInterface $participant, $isRead);
}
