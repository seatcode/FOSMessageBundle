<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Search;

use Stringable;

class Query implements Stringable
{
    public function __construct(
        protected string $original,
        protected string $escaped
    ) {
    }

    public function getOriginal(): string
    {
        return $this->original;
    }

    public function setOriginal(string $original): void
    {
        $this->original = $original;
    }

    public function getEscaped(): string
    {
        return $this->escaped;
    }

    public function setEscaped(string $escaped): void
    {
        $this->escaped = $escaped;
    }

    public function __toString(): string
    {
        return $this->getOriginal();
    }

    public function isEmpty(): bool
    {
        return empty($this->original);
    }
}
