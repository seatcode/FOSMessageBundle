<?php

declare(strict_types=1);

namespace FOS\MessageBundle\SpamDetection;

use FOS\MessageBundle\FormModel\NewThreadMessage;

class NoopSpamDetector implements SpamDetectorInterface
{
    /**
     * {@inheritdoc}
     */
    public function isSpam(NewThreadMessage $message): bool
    {
        return false;
    }
}
