<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Validator;

use FOS\MessageBundle\SpamDetection\SpamDetectorInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class SpamValidator extends ConstraintValidator
{
    protected SpamDetectorInterface $spamDetector;

    public function __construct(SpamDetectorInterface $spamDetector)
    {
        $this->spamDetector = $spamDetector;
    }

    /**
     * Indicates whether the constraint is valid.
     *
     * @param object $value
     */
    public function validate($value, Constraint $constraint): void
    {
        if ($this->spamDetector->isSpam($value)) {
            $this->context->addViolation($constraint->message);
        }
    }
}
