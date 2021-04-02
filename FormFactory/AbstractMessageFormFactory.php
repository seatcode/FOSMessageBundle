<?php

declare(strict_types=1);

namespace FOS\MessageBundle\FormFactory;

use FOS\MessageBundle\FormModel\AbstractMessage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Instanciates message forms.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
abstract class AbstractMessageFormFactory
{
    public function __construct(
        protected FormFactoryInterface $formFactory,
        protected string | AbstractType $formType,
        protected string $formName,
        protected string $messageClass
    ) {
    }

    protected function createModelInstance(): AbstractMessage
    {
        $class = $this->messageClass;

        return new $class();
    }
}
