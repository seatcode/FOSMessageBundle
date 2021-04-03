<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Validator;

use FOS\MessageBundle\Security\AuthorizerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AuthorizationValidator extends ConstraintValidator
{
    public function __construct(
        protected AuthorizerInterface $authorizer
    ) {
    }

    /**
     * Indicates whether the constraint is valid.
     *
     * @param object $recipient
     */
    public function validate($recipient, Constraint $constraint): void
    {
        if ($recipient && !$this->authorizer->canMessageParticipant($recipient)) {
            $this->context->addViolation($constraint->message);
        }
    }
}
