<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Search;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class QueryFactory implements QueryFactoryInterface
{
    public function __construct(
        protected RequestStack $requestStack,
        protected string $queryParameter
    ) {
    }

    public function createFromRequest(): Query
    {
        $original = $this->getCurrentRequest()->query->get($this->queryParameter);
        $original = trim($original);

        $escaped = $this->escapeTerm($original);

        return new Query($original, $escaped);
    }

    /**
     * Sets: the query parameter containing the search term.
     */
    public function setQueryParameter(string $queryParameter): void
    {
        $this->queryParameter = $queryParameter;
    }

    private function escapeTerm($term)
    {
        return $term;
    }

    private function getCurrentRequest(): ?Request
    {
        return $this->requestStack->getCurrentRequest();
    }
}
