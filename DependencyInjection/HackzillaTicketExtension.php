<?php

namespace Hackzilla\Bundle\TicketBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class HackzillaTicketExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(self::bundleDirectory().'/Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('hackzilla_ticket.admin_role', $config['admin_role']);
        $container->setParameter('hackzilla_ticket.model.user.class', $config['user_class']);
        $container->setParameter('hackzilla_ticket.model.ticket.class', $config['ticket_class']);
        $container->setParameter('hackzilla_ticket.model.message.class', $config['message_class']);

        $container->setParameter('hackzilla_ticket.default_username', $config['default_username']);
        $container->setParameter('hackzilla_ticket.features', $config['features']);
        $container->setParameter('hackzilla_ticket.pagination', $config['pagination']);
        $container->setParameter('hackzilla_ticket.templates', $config['templates']);

        $container->setAlias('hackzilla_ticket.event_manager', $config['event_manager']);
        $container->setAlias('hackzilla_ticket.storage_manager', $config['storage_manager']);
        $container->setAlias('hackzilla_ticket.translate_manager', $config['translate_manager']);
        $container->setAlias('hackzilla_ticket.user_manager', $config['user_manager']);
    }

    public static function bundleDirectory()
    {
        return realpath(__DIR__.'/..');
    }
}
