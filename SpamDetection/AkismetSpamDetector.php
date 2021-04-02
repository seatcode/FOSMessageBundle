<?php

declare(strict_types=1);

namespace FOS\MessageBundle\SpamDetection;

use FOS\MessageBundle\FormModel\NewThreadMessage;
use FOS\MessageBundle\Security\ParticipantProviderInterface;
use Ornicar\AkismetBundle\Akismet\AkismetInterface;

class AkismetSpamDetector implements SpamDetectorInterface
{
    public function __construct(
        protected AkismetInterface $akismet,
        protected ParticipantProviderInterface $participantProvider
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function isSpam(NewThreadMessage $message): bool
    {
        return $this->akismet->isSpam([
            'comment_author' => (string) $this->participantProvider->getAuthenticatedParticipant(),
            'comment_content' => $message->getBody(),
        ]);
    }
}
