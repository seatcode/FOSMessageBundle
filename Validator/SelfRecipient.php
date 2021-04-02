<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Validator;

use Symfony\Component\Validator\Constraint;

class SelfRecipient extends Constraint
{
    public string $message = 'fos_message.self_recipient';

    public function validatedBy(): string
    {
        return 'fos_message.validator.self_recipient';
    }

    /**
     * {@inheritdoc}
     */
    public function getTargets(): string
    {
        return self::PROPERTY_CONSTRAINT;
    }
}
