<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Tests\Functional;

class FunctionalTest extends WebTestCase
{
    public function testController(): void
    {
        $client = self::createClient([], [
            'PHP_AUTH_USER' => 'guilhem',
            'PHP_AUTH_PW' => 'pass',
        ]);
        $crawler = $client->request('GET', '/sent');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }
}
