<?php

declare(strict_types=1);

namespace FOS\MessageBundle\FormModel;

abstract class AbstractMessage
{
    protected string $body;

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }
}
