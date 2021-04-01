<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;

class WebTestCase extends BaseWebTestCase
{
    protected static function getKernelClass()
    {
        return TestKernel::class;
    }
}
