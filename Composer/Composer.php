<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Composer;

use FOS\MessageBundle\MessageBuilder\NewThreadMessageBuilder;
use FOS\MessageBundle\MessageBuilder\ReplyMessageBuilder;
use FOS\MessageBundle\Model\ThreadInterface;
use FOS\MessageBundle\ModelManager\MessageManagerInterface;
use FOS\MessageBundle\ModelManager\ThreadManagerInterface;

class Composer implements ComposerInterface
{
    public function __construct(
        private MessageManagerInterface $messageManager,
        private ThreadManagerInterface $threadManager
    ) {
    }

    public function newThread(): NewThreadMessageBuilder
    {
        return new NewThreadMessageBuilder($this->messageManager->createMessage(), $this->threadManager->createThread());
    }

    public function reply(ThreadInterface $thread): ReplyMessageBuilder
    {
        return new ReplyMessageBuilder($this->messageManager->createMessage(), $thread);
    }
}
