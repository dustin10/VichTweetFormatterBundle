<?php

namespace Vich\TweetFormatterBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Vich\TweetFormatterBundle\DependencyInjection\Configuration;

/**
 * VichTweetFormatterExtension.
 *
 * @author Dustin Dobervich <ddobervich@gmail.com>
 */
class VichTweetFormatterExtension extends Extension
{
    /**
     * Loads the extension.
     * 
     * @param array $configs The configuration
     * @param ContainerBuilder $container The container builder
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        
        $config = $this->processConfiguration($configuration, $configs);
        
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        
        $toLoad = array('services.xml', 'templating.xml');
        foreach ($toLoad as $file) {
            $loader->load($file);
        }
        
        if ($config['twig']) {
            $loader->load('twig.xml');
        }
        
        $container->setParameter('vich_tweet_formatter.link_target_attr', $config['link_target_attr']);
        $container->setParameter('vich_tweet_formatter.link_css_class', $config['link_css_class']);
    }
}
