<?php

declare(strict_types=1);

namespace FOS\MessageBundle\SpamDetection;

use FOS\MessageBundle\FormModel\NewThreadMessage;

/**
 * Tells whether or not a new message looks like spam.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
interface SpamDetectorInterface
{
    /**
     * Tells whether or not a new message looks like spam.
     *
     * @return bool true if it is spam, false otherwise
     */
    public function isSpam(NewThreadMessage $message);
}
