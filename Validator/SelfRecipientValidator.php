<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Validator;

use FOS\MessageBundle\Security\ParticipantProviderInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class SelfRecipientValidator extends ConstraintValidator
{
    public function __construct(
        protected ParticipantProviderInterface $participantProvider
    ) {
    }

    /**
     * Indicates whether the constraint is valid.
     *
     * @param object $recipient
     */
    public function validate($recipient, Constraint $constraint): void
    {
        if ($recipient === $this->participantProvider->getAuthenticatedParticipant()) {
            $this->context->addViolation($constraint->message);
        }
    }
}
