<?php

declare(strict_types=1);

namespace FOS\MessageBundle\FormFactory;

use Symfony\Component\Form\FormInterface;

/**
 * Instanciates message forms.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class NewThreadMessageFormFactory extends AbstractMessageFormFactory
{
    public function create(): FormInterface
    {
        return $this->formFactory->createNamed($this->formName, $this->formType, $this->createModelInstance());
    }
}
