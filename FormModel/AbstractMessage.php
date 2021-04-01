<?php

declare(strict_types=1);

namespace FOS\MessageBundle\FormModel;

abstract class AbstractMessage
{
    /**
     * @var string
     */
    protected $body;

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string
     */
    public function setBody($body): void
    {
        $this->body = $body;
    }
}
