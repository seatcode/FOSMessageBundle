<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Tests\Functional;

use FOS\MessageBundle\FOSMessageBundle;
use FOS\MessageBundle\Tests\Functional\Entity\Message;
use FOS\MessageBundle\Tests\Functional\Entity\Thread;
use FOS\MessageBundle\Tests\Functional\Entity\User;
use FOS\MessageBundle\Tests\Functional\Entity\UserProvider;
use FOS\MessageBundle\Tests\Functional\EntityManager\MessageManager;
use FOS\MessageBundle\Tests\Functional\EntityManager\ThreadManager;
use FOS\MessageBundle\Tests\Functional\Form\UserToUsernameTransformer;
use JetBrains\PhpStorm\Pure;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

/**
 * @author Guilhem N. <guilhem.niot@gmail.com>
 */
final class TestKernel extends Kernel
{
    use MicroKernelTrait;

    /** {@inheritdoc} */
    #[Pure]
    public function registerBundles(): iterable
    {
        return [
            new FrameworkBundle(),
            new SecurityBundle(),
            new TwigBundle(),
            new FOSMessageBundle(),
            new MyTestBundle(),
        ];
    }

    /** {@inheritdoc} */
    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import('@FOSMessageBundle/Resources/config/routing.xml');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->extension('framework', [
            'secret' => 'MySecretKey',
            'test' => null,
            'form' => null,
            'router' => [
                'utf8' => true,
            ],
        ]);

        $container->extension('security', [
            'providers' => ['permissive' => ['id' => 'app.user_provider']],
            'encoders' => [User::class => 'plaintext'],
            'firewalls' => ['main' => ['http_basic' => true]],
        ]);

        $container->extension('twig', [
            'strict_variables' => '%kernel.debug%',
        ]);

        $container->extension('fos_message', [
            'thread_class' => Thread::class,
            'message_class' => Message::class,
        ]);

        $container->services()->set('fos_user.user_to_username_transformer', UserToUsernameTransformer::class);
        $container->services()->set('app.user_provider', UserProvider::class);
    }
}

final class MyTestBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new RegisteringManagersPass());
    }
}

final class RegisteringManagersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $container->register('fos_message.message_manager.default', MessageManager::class);
        $container->register('fos_message.thread_manager.default', ThreadManager::class);
    }
}
