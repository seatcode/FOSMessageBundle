<?php

declare(strict_types=1);

namespace FOS\MessageBundle\ModelManager;

use FOS\MessageBundle\Model\ThreadInterface;

/**
 * Abstract Thread Manager implementation which can be used as base class by your
 * concrete manager.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
abstract class ThreadManager implements ThreadManagerInterface
{
    public function createThread(): ThreadInterface
    {
        $class = $this->getClass();

        return new $class();
    }
}
