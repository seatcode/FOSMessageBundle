<?php

declare(strict_types=1);

namespace FOS\MessageBundle\FormHandler;

use FOS\MessageBundle\Composer\ComposerInterface;
use FOS\MessageBundle\FormModel\AbstractMessage;
use FOS\MessageBundle\Model\MessageInterface;
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Security\ParticipantProviderInterface;
use FOS\MessageBundle\Sender\SenderInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Handles messages forms, from binding request to sending the message.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
abstract class AbstractMessageFormHandler
{
    public function __construct(
        protected RequestStack $requestStack,
        protected ComposerInterface $composer,
        protected SenderInterface $sender,
        protected ParticipantProviderInterface $participantProvider
    ) {
    }

    /**
     * Processes the form with the request.
     *
     * @return MessageInterface|false the sent message if the form is bound and valid, false otherwise
     */
    public function process(FormInterface $form): false | MessageInterface
    {
        $request = $this->getCurrentRequest();

        if ('POST' !== $request->getMethod()) {
            return false;
        }

        $form->handleRequest($request);

        if ($form->isValid()) {
            return $this->processValidForm($form);
        }

        return false;
    }

    /**
     * Processes the valid form, sends the message.
     *
     * @return MessageInterface the sent message
     */
    public function processValidForm(FormInterface $form): MessageInterface
    {
        $message = $this->composeMessage($form->getData());
        $this->sender->send($message);

        return $message;
    }

    /**
     * Composes a message from the form data.
     *
     * @return MessageInterface the composed message ready to be sent
     */
    abstract protected function composeMessage(AbstractMessage $message): MessageInterface;

    /**
     * Gets the current authenticated user.
     */
    protected function getAuthenticatedParticipant(): ParticipantInterface
    {
        return $this->participantProvider->getAuthenticatedParticipant();
    }

    /**
     * BC layer to retrieve the current request directly or from a stack.
     */
    private function getCurrentRequest(): Request
    {
        return $this->requestStack->getCurrentRequest();
    }
}
