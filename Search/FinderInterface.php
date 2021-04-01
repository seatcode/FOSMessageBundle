<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Search;

use Doctrine\ORM\QueryBuilder;
use FOS\MessageBundle\Model\ThreadInterface;

/**
 * Finds threads of a participant, matching a given query.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
interface FinderInterface
{
    /**
     * Finds threads of a participant, matching a given query.
     *
     * @return ThreadInterface[]
     */
    public function find(Query $query): array;

    /**
     * Finds threads of a participant, matching a given query.
     */
    public function getQueryBuilder(Query $query): QueryBuilder;
}
