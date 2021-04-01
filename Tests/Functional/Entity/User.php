<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Tests\Functional\Entity;

use FOS\MessageBundle\Model\ParticipantInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements ParticipantInterface, UserInterface
{
    public function getUsername()
    {
        return 'guilhem';
    }

    public function getPassword()
    {
        return 'pass';
    }

    public function getSalt(): void
    {
    }

    public function getRoles()
    {
        return [];
    }

    public function eraseCredentials(): void
    {
    }

    public function getId()
    {
        return 1;
    }
}
