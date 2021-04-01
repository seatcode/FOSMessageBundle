<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Tests\EntityManager;

use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use FOS\MessageBundle\Entity\Message;
use FOS\MessageBundle\EntityManager\ThreadManager;
use FOS\MessageBundle\Model\MessageInterface;
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\ThreadInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class ThreadManagerTest extends TestCase
{
    protected $user;
    protected $date;

    public function setUp(): void
    {
        $this->user = $this->createParticipantMock(4711);
        $this->date = new \DateTime('2013-12-25');
    }

    /**
     * Usual test case where neither createdBy or createdAt is set.
     */
    public function testDoCreatedByAndAt(): void
    {
        $thread = $this->createThreadMock($this->user, $this->date, $this->createMessageMock());

        $threadManager = new TestThreadManager();
        $threadManager->doCreatedByAndAt($thread);

        $this->assertSame(1, $thread->getNumberOfTimesCalled('getFirstMessage'));
    }

    /**
     * Test where createdBy is set.
     */
    public function testDoCreatedByAndAtWithCreatedBy(): void
    {
        $thread = $this->createThreadMock($this->user, null, $this->createMessageMock());

        $threadManager = new TestThreadManager();
        $threadManager->doCreatedByAndAt($thread);

        self::assertSame(0, $thread->getNumberOfTimesCalled('setCreatedBy'));
        self::assertSame(1, $thread->getNumberOfTimesCalled('setCreatedAt'));
        self::assertSame(1, $thread->getNumberOfTimesCalled('getCreatedBy'));
        self::assertSame(1, $thread->getNumberOfTimesCalled('getFirstMessage'));
    }

    /**
     * Test where createdAt is set.
     */
    public function testDoCreatedByAndAtWithCreatedAt(): void
    {
        $thread = $this->createThreadMock(null, $this->date, $this->createMessageMock());

        $threadManager = new TestThreadManager();
        $threadManager->doCreatedByAndAt($thread);

        self::assertSame(1, $thread->getNumberOfTimesCalled('setCreatedBy'));
        self::assertSame(0, $thread->getNumberOfTimesCalled('setCreatedAt'));
        self::assertSame(1, $thread->getNumberOfTimesCalled('getCreatedBy'));
        self::assertSame(1, $thread->getNumberOfTimesCalled('getFirstMessage'));
    }

    /**
     * Test where both craetedAt and createdBy is set.
     */
    public function testDoCreatedByAndAtWithCreatedAtAndBy(): void
    {
        $thread = $this->createThreadMock($this->user, $this->date, $this->createMessageMock());

        $threadManager = new TestThreadManager();
        $threadManager->doCreatedByAndAt($thread);

        self::assertSame(0, $thread->getNumberOfTimesCalled('setCreatedBy'));
        self::assertSame(0, $thread->getNumberOfTimesCalled('setCreatedAt'));
        self::assertSame(1, $thread->getNumberOfTimesCalled('getCreatedBy'));
        self::assertSame(1, $thread->getNumberOfTimesCalled('getCreatedAt'));
        self::assertSame(1, $thread->getNumberOfTimesCalled('getFirstMessage'));
    }

    /**
     * Test where thread do not have a message.
     */
    public function testDoCreatedByAndNoMessage(): void
    {
        $thread = $this->createThreadMock($this->user, $this->date, null);

        $threadManager = new TestThreadManager();
        $threadManager->doCreatedByAndAt($thread);

        self::assertSame(0, $thread->getNumberOfTimesCalled('setCreatedBy'));
        self::assertSame(0, $thread->getNumberOfTimesCalled('setCreatedAt'));
        self::assertSame(0, $thread->getNumberOfTimesCalled('getCreatedAt'));
        self::assertSame(0, $thread->getNumberOfTimesCalled('getCreatedBy'));
    }

    private function createMessageMock(): MessageInterface
    {
        return new class($this->user, $this->date) extends Message {
            public function __construct(
                private $user,
                private $date
            ) {
            }

            public function getCreatedAt(): DateTimeInterface
            {
                return $this->date;
            }

            public function getSender(): ParticipantInterface
            {
                return $this->user;
            }
        };
    }

    protected function createParticipantMock(int $id): MockObject | ParticipantInterface
    {
        $participant = $this->getMockBuilder(ParticipantInterface::class)
            ->disableOriginalConstructor(true)
            ->getMock();

        $participant->method('getId')->willReturn($id);

        return $participant;
    }

    protected function createThreadMock(mixed $user, mixed $date, ?MessageInterface $message)
    {
        return new class($user, $date, $message) implements ThreadInterface {
            private array $calledMethods = [];

            public function __construct(private $user, private $date, private ?MessageInterface $message)
            {
            }

            public function isReadByParticipant(ParticipantInterface $participant): bool
            {
                // TODO: Implement isReadByParticipant() method.
            }

            public function setIsReadByParticipant(ParticipantInterface $participant, bool $isRead): void
            {
                // TODO: Implement setIsReadByParticipant() method.
            }

            public function getId(): int
            {
                // TODO: Implement getId() method.
            }

            public function getSubject(): string
            {
                // TODO: Implement getSubject() method.
            }

            public function setSubject(string $subject): void
            {
                // TODO: Implement setSubject() method.
            }

            public function getMessages(): Collection | array
            {
                // TODO: Implement getMessages() method.
            }

            public function addMessage(MessageInterface $message): void
            {
                // TODO: Implement addMessage() method.
            }

            public function getFirstMessage(): ?MessageInterface
            {
                if (!isset($this->calledMethods[__FUNCTION__])) {
                    $this->calledMethods[__FUNCTION__] = 0;
                }

                ++$this->calledMethods[__FUNCTION__];

                return $this->message;
            }

            public function getLastMessage(): ?MessageInterface
            {
                // TODO: Implement getLastMessage() method.
            }

            public function getCreatedBy(): ?ParticipantInterface
            {
                if (!isset($this->calledMethods[__FUNCTION__])) {
                    $this->calledMethods[__FUNCTION__] = 0;
                }

                ++$this->calledMethods[__FUNCTION__];

                return $this->user;
            }

            public function setCreatedBy(ParticipantInterface $participant): void
            {
                if (!isset($this->calledMethods[__FUNCTION__])) {
                    $this->calledMethods[__FUNCTION__] = 0;
                }

                ++$this->calledMethods[__FUNCTION__];
            }

            public function getCreatedAt(): ?DateTimeInterface
            {
                if (!isset($this->calledMethods[__FUNCTION__])) {
                    $this->calledMethods[__FUNCTION__] = 0;
                }

                ++$this->calledMethods[__FUNCTION__];

                return $this->date;
            }

            public function setCreatedAt(DateTimeInterface $createdAt): void
            {
                if (!isset($this->calledMethods[__FUNCTION__])) {
                    $this->calledMethods[__FUNCTION__] = 0;
                }

                ++$this->calledMethods[__FUNCTION__];
            }

            public function getParticipants(): Collection | array
            {
                // TODO: Implement getParticipants() method.
            }

            public function isParticipant(ParticipantInterface $participant): bool
            {
                // TODO: Implement isParticipant() method.
            }

            public function addParticipant(ParticipantInterface $participant): void
            {
                // TODO: Implement addParticipant() method.
            }

            public function isDeletedByParticipant(ParticipantInterface $participant): bool
            {
                // TODO: Implement isDeletedByParticipant() method.
            }

            public function setIsDeletedByParticipant(ParticipantInterface $participant, bool $isDeleted): void
            {
                // TODO: Implement setIsDeletedByParticipant() method.
            }

            public function setIsDeleted(bool $isDeleted): void
            {
                // TODO: Implement setIsDeleted() method.
            }

            public function getOtherParticipants(ParticipantInterface $participant): array
            {
                // TODO: Implement getOtherParticipants() method.
            }

            public function getNumberOfTimesCalled(string $method): int
            {
                return $this->calledMethods[$method] ?? 0;
            }
        };
    }
}

class TestThreadManager extends ThreadManager
{
    /**
     * Empty constructor.
     */
    public function __construct()
    {
    }

    /**
     * Make the function public.
     */
    public function doCreatedByAndAt(ThreadInterface $thread): void
    {
        parent::doCreatedByAndAt($thread);
    }
}
