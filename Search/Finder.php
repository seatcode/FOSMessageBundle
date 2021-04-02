<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Search;

use Doctrine\ORM\QueryBuilder;
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\ModelManager\ThreadManagerInterface;
use FOS\MessageBundle\Security\ParticipantProviderInterface;

/**
 * Finds threads of a participant, matching a given query.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class Finder implements FinderInterface
{
    public function __construct(
        protected ParticipantProviderInterface $participantProvider,
        protected ThreadManagerInterface $threadManager
    ) {
    }

    public function find(Query $query): array
    {
        return $this->threadManager->findParticipantThreadsBySearch($this->getAuthenticatedParticipant(), $query->getEscaped());
    }

    public function getQueryBuilder(Query $query): QueryBuilder
    {
        return $this->threadManager->getParticipantThreadsBySearchQueryBuilder($this->getAuthenticatedParticipant(), $query->getEscaped());
    }

    protected function getAuthenticatedParticipant(): ParticipantInterface
    {
        return $this->participantProvider->getAuthenticatedParticipant();
    }
}
