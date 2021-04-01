<?php

declare(strict_types=1);

namespace FOS\MessageBundle\FormModel;

use FOS\MessageBundle\Model\ParticipantInterface;

class NewThreadMessage extends AbstractMessage
{
    /**
     * The user who receives the message.
     *
     * @var ParticipantInterface
     */
    protected $recipient;

    /**
     * The thread subject.
     *
     * @var string
     */
    protected $subject;

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string
     */
    public function setSubject($subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return ParticipantInterface
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @param ParticipantInterface
     */
    public function setRecipient($recipient): void
    {
        $this->recipient = $recipient;
    }
}
