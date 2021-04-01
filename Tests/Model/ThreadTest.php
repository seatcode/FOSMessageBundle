<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Tests\Model;

use FOS\MessageBundle\Model\ParticipantInterface;
use PHPUnit\Framework\TestCase;
use FOS\MessageBundle\Model\Thread;

class ThreadTest extends TestCase
{
    public function testGetOtherParticipants(): void
    {
        $u1 = $this->createParticipantMock(1);
        $u2 = $this->createParticipantMock(2);
        $u3 = $this->createParticipantMock(3);

        $thread = $this->getMockForAbstractClass(Thread::class);
        $thread->expects(self::atLeastOnce())->method('getParticipants')->willReturn([$u1, $u2, $u3]);

        $toIds = static function (array $participants) {
            return array_map(static function (ParticipantInterface $participant) {
                return $participant->getId();
            }, $participants);
        };

        self::assertSame($toIds([$u2, $u3]), $toIds($thread->getOtherParticipants($u1)));
        self::assertSame($toIds([$u1, $u3]), $toIds($thread->getOtherParticipants($u2)));
        self::assertSame($toIds([$u1, $u2]), $toIds($thread->getOtherParticipants($u3)));
    }

    protected function createParticipantMock(int $id)
    {
        $participant = $this->getMockBuilder(ParticipantInterface::class)
            ->disableOriginalConstructor(true)
            ->getMock();

        $participant->method('getId')->willReturn($id);

        return $participant;
    }
}
