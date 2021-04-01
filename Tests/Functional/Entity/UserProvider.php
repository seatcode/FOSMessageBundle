<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Tests\Functional\Entity;

use JetBrains\PhpStorm\Pure;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    #[Pure]
    public function loadUserByUsername($username): User
    {
        return new User();
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user;
    }

    public function supportsClass($class): bool
    {
        return User::class === $class;
    }

    private function fetchUser($username): User
    {
        return new User();
    }
}
