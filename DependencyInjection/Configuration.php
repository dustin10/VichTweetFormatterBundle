<?php

namespace Vich\TweetFormatterBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration.
 *
 * @author Dustin Dobervich <ddobervich@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Gets the configuration tree builder for the extension.
     * 
     * @return TreeBuilder The configuration tree builder
     */
    public function getConfigTreeBuilder()
    {
        $tb = new TreeBuilder();
        $root = $tb->root('vich_tweet_formatter');
        
        $root
            ->children()
                ->scalarNode('twig')->cannotBeEmpty()->defaultFalse()->end()
                ->scalarNode('link_target_attr')->cannotBeEmpty()->defaultValue('_blank')->end()
                ->scalarNode('link_css_class')->defaultValue('')->end()
            ->end()
        ;
        
        return $tb;
    }
}
