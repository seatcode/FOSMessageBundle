<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Search;

/**
 * Gets the search term from the request and prepares it.
 */
interface QueryFactoryInterface
{
    public function createFromRequest(): Query;
}
