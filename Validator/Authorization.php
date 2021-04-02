<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Validator;

use Symfony\Component\Validator\Constraint;

class Authorization extends Constraint
{
    public string $message = 'fos_message.not_authorized';

    public function validatedBy(): string
    {
        return 'fos_message.validator.authorization';
    }

    /** {@inheritdoc} */
    public function getTargets(): string
    {
        return self::PROPERTY_CONSTRAINT;
    }
}
