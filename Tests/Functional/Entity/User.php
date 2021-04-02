<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Tests\Functional\Entity;

use FOS\MessageBundle\Model\ParticipantInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements ParticipantInterface, UserInterface
{
    public function getUsername(): string
    {
        return 'guilhem';
    }

    public function getPassword(): string
    {
        return 'pass';
    }

    public function getSalt(): void
    {
    }

    public function getRoles(): array
    {
        return [];
    }

    public function eraseCredentials(): void
    {
    }

    public function getId(): ?int
    {
        return 1;
    }
}
