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
    protected FormFactoryInterface $formFactory;
    protected string | AbstractType $formType;
    protected string $formName;
    protected string $messageClass;

    public function __construct(FormFactoryInterface $formFactory, string | AbstractType $formType, string $formName, string $messageClass)
    {
        $this->formFactory = $formFactory;
        $this->formType = $formType;
        $this->formName = $formName;
        $this->messageClass = $messageClass;
    }

    protected function createModelInstance(): AbstractMessage
    {
        $class = $this->messageClass;

        return new $class();
    }
}
