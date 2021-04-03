<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Validator;

use FOS\MessageBundle\Security\AuthorizerInterface;
use FOS\MessageBundle\Security\ParticipantProviderInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ReplyAuthorizationValidator extends ConstraintValidator
{
    public function __construct(
        protected AuthorizerInterface $authorizer,
        protected ParticipantProviderInterface $participantProvider
    ) {
    }

    /**
     * Indicates whether the constraint is valid.
     *
     * @param object $value
     */
    public function validate($value, Constraint $constraint): void
    {
        $sender = $this->participantProvider->getAuthenticatedParticipant();
        $recipients = $value->getThread()->getOtherParticipants($sender);

        foreach ($recipients as $recipient) {
            if (!$this->authorizer->canMessageParticipant($recipient)) {
                $this->context->addViolation($constraint->message);

                return;
            }
        }
    }
}
