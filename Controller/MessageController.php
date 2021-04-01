<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Controller;

use FOS\MessageBundle\Deleter\DeleterInterface;
use FOS\MessageBundle\FormFactory\NewThreadMessageFormFactory;
use FOS\MessageBundle\FormFactory\ReplyMessageFormFactory;
use FOS\MessageBundle\FormHandler\NewThreadMessageFormHandler;
use FOS\MessageBundle\FormHandler\ReplyMessageFormHandler;
use FOS\MessageBundle\ModelManager\ThreadManagerInterface;
use FOS\MessageBundle\Provider\ProviderInterface;
use FOS\MessageBundle\Search\FinderInterface;
use FOS\MessageBundle\Search\QueryFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

final class MessageController extends AbstractController
{
    public function __construct(
        private ReplyMessageFormFactory $replyMessageFormFactory,
        private ReplyMessageFormHandler $replyMessageFormHandler,
        private NewThreadMessageFormFactory $newThreadMessageFormFactory,
        private NewThreadMessageFormHandler $newThreadMessageFormHandler,
        private DeleterInterface $deleter,
        private ThreadManagerInterface $threadManager,
        private QueryFactoryInterface $queryFactory,
        private FinderInterface $finder,
        private ProviderInterface $provider,
    ) {
    }

    public function inboxAction(): Response
    {
        $threads = $this->provider->getInboxThreads();

        return $this->render('@FOSMessage/Message/inbox.html.twig', [
            'threads' => $threads,
        ]);
    }

    public function sentAction(): Response
    {
        $threads = $this->provider->getSentThreads();

        return $this->render('@FOSMessage/Message/sent.html.twig', [
            'threads' => $threads,
        ]);
    }

    public function deletedAction(): Response
    {
        $threads = $this->provider->getDeletedThreads();

        return $this->render('@FOSMessage/Message/deleted.html.twig', [
            'threads' => $threads,
        ]);
    }

    public function threadAction(string $threadId): Response
    {
        $thread = $this->provider->getThread($threadId);
        $form = $this->replyMessageFormFactory->create($thread);

        if ($message = $this->replyMessageFormHandler->process($form)) {
            return $this->redirectToRoute('fos_message_thread_view', [
                'threadId' => $message->getThread()->getId(),
            ]);
        }

        return $this->render('@FOSMessage/Message/thread.html.twig', [
            'form' => $form->createView(),
            'thread' => $thread,
        ]);
    }

    public function newThreadAction(): Response
    {
        $form = $this->newThreadMessageFormFactory->create();

        if ($message = $this->newThreadMessageFormHandler->process($form)) {
            return $this->redirectToRoute('fos_message_thread_view', [
                'threadId' => $message->getThread()->getId(),
            ]);
        }

        return $this->render('@FOSMessage/Message/newThread.html.twig', [
            'form' => $form->createView(),
            'data' => $form->getData(),
        ]);
    }

    public function deleteAction(string $threadId): RedirectResponse
    {
        $thread = $this->provider->getThread($threadId);
        $this->deleter->markAsDeleted($thread);
        $this->threadManager->saveThread($thread);

        return $this->redirectToRoute('fos_message_inbox');
    }

    public function undeleteAction(string $threadId): Response
    {
        $thread = $this->provider->getThread($threadId);
        $this->deleter->markAsUndeleted($thread);
        $this->threadManager->saveThread($thread);

        return $this->redirectToRoute('fos_message_inbox');
    }

    /**
     * Searches for messages in the inbox and sentbox.
     */
    public function searchAction(): Response
    {
        $query = $this->queryFactory->createFromRequest();
        $threads = $this->finder->find($query);

        return $this->render('@FOSMessage/Message/search.html.twig', [
            'query' => $query,
            'threads' => $threads,
        ]);
    }
}
