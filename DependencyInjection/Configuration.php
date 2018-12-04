<?php

namespace Hackzilla\Bundle\TicketBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $treeBuilder->root('hackzilla_ticket')
            ->children()
                ->scalarNode('admin_role')->cannotBeEmpty()->defaultValue('ROLE_TICKET_ADMIN')->end()
                ->scalarNode('user_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('default_username')->isRequired()->defaultValue('system')->end()
                ->scalarNode('ticket_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('message_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('event_manager')->cannotBeEmpty()->defaultValue('hackzilla_ticket.event_manager.symfony')->end()
                ->scalarNode('storage_manager')->cannotBeEmpty()->defaultValue('hackzilla_ticket.storage_manager.doctrine_orm')->end()
                ->scalarNode('translate_manager')->cannotBeEmpty()->defaultValue('hackzilla_ticket.translate_manager.symfony')->end()
                ->scalarNode('user_manager')->cannotBeEmpty()->defaultValue('hackzilla_ticket.user_manager.symfony')->end()
                ->arrayNode('features')
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('pagination')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('page_name')->cannotBeEmpty()->defaultValue('page')->end()
                        ->scalarNode('sort_field_name')->cannotBeEmpty()->defaultValue('sort')->end()
                        ->scalarNode('sort_direction_name')->cannotBeEmpty()->defaultValue('direction')->end()
                        ->integerNode('items_per_page')->defaultValue(10)->end()
                    ->end()
                ->end()
                ->arrayNode('templates')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->scalarNode('index')->defaultValue('HackzillaTicketBundle:Ticket:index.html.twig')->end()
                        ->scalarNode('new')->defaultValue('HackzillaTicketBundle:Ticket:new.html.twig')->end()
                        ->scalarNode('prototype')->defaultValue('HackzillaTicketBundle:Ticket:prototype.html.twig')->end()
                        ->scalarNode('show')->defaultValue('HackzillaTicketBundle:Ticket:show.html.twig')->end()
                        ->scalarNode('show_attachment')->defaultValue('HackzillaTicketBundle:Ticket:show_attachment.html.twig')->end()
                        ->scalarNode('macros')->defaultValue('HackzillaTicketBundle:Macros:macros.html.twig')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
