<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Validator;

use Symfony\Component\Validator\Constraint;

class ReplyAuthorization extends Constraint
{
    public string $message = 'fos_message.reply_not_authorized';

    public function validatedBy(): string
    {
        return 'fos_message.validator.reply_authorization';
    }

    /**
     * {@inheritdoc}
     */
    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
