<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Tests\Twig\Extension;

use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\ReadableInterface;
use FOS\MessageBundle\Model\ThreadInterface;
use FOS\MessageBundle\Provider\ProviderInterface;
use FOS\MessageBundle\Security\AuthorizerInterface;
use FOS\MessageBundle\Security\ParticipantProviderInterface;
use FOS\MessageBundle\Twig\Extension\MessageExtension;
use PHPUnit\Framework\TestCase;

/**
 * Testfile for MessageExtension.
 */
class MessageExtensionTest extends TestCase
{
    private $extension;
    private $participantProvider;
    private $provider;
    private $authorizer;
    private $participant;

    public function setUp(): void
    {
        $this->participantProvider = $this->getMockBuilder(ParticipantProviderInterface::class)->getMock();
        $this->provider = $this->getMockBuilder(ProviderInterface::class)->getMock();
        $this->authorizer = $this->getMockBuilder(AuthorizerInterface::class)->getMock();
        $this->participant = $this->getMockBuilder(ParticipantInterface::class)->getMock();
        $this->extension = new MessageExtension($this->participantProvider, $this->provider, $this->authorizer);
    }

    public function testIsReadReturnsTrueWhenRead(): void
    {
        $this->participantProvider->expects($this->once())->method('getAuthenticatedParticipant')->will($this->returnValue($this->participant));
        $readAble = $this->getMockBuilder(ReadableInterface::class)->getMock();
        $readAble->expects($this->once())->method('isReadByParticipant')->with($this->participant)->will($this->returnValue(true));
        $this->assertTrue($this->extension->isRead($readAble));
    }

    public function testIsReadReturnsFalseWhenNotRead(): void
    {
        $this->participantProvider->expects($this->once())->method('getAuthenticatedParticipant')->will($this->returnValue($this->participant));
        $readAble = $this->getMockBuilder(ReadableInterface::class)->getMock();
        $readAble->expects($this->once())->method('isReadByParticipant')->with($this->participant)->will($this->returnValue(false));
        $this->assertFalse($this->extension->isRead($readAble));
    }

    public function testCanDeleteThreadWhenHasPermission(): void
    {
        $thread = $this->getThreadMock();
        $this->authorizer->expects($this->once())->method('canDeleteThread')->with($thread)->will($this->returnValue(true));
        $this->assertTrue($this->extension->canDeleteThread($thread));
    }

    public function testCanDeleteThreadWhenNoPermission(): void
    {
        $thread = $this->getThreadMock();
        $this->authorizer->expects($this->once())->method('canDeleteThread')->with($thread)->will($this->returnValue(false));
        $this->assertFalse($this->extension->canDeleteThread($thread));
    }

    public function testIsThreadDeletedByParticipantWhenDeleted(): void
    {
        $thread = $this->getThreadMock();
        $this->participantProvider->expects($this->once())->method('getAuthenticatedParticipant')->will($this->returnValue($this->participant));
        $thread->expects($this->once())->method('isDeletedByParticipant')->with($this->participant)->will($this->returnValue(true));
        $this->assertTrue($this->extension->isThreadDeletedByParticipant($thread));
    }

    public function testGetNbUnread(): void
    {
        $this->provider->expects($this->once())->method('getNbUnreadMessages')->will($this->returnValue(3));
        $this->assertEquals(3, $this->extension->getNbUnread());
    }

    public function testGetNbUnreadStoresCache(): void
    {
        $this->provider->expects($this->once())->method('getNbUnreadMessages')->will($this->returnValue(3));
        //we call it twice but expect to only get one call
        $this->extension->getNbUnread();
        $this->extension->getNbUnread();
    }

    protected function getThreadMock()
    {
        return $this->getMockBuilder(ThreadInterface::class)->getMock();
    }
}
