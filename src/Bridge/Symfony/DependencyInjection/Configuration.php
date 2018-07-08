<?php

namespace KunicMarko\Importer\Bridge\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('importer');

        $rootNode
            ->children()
            ->scalarNode('')->defaultNull()->end()
            ->end();

        return $treeBuilder;
    }
}
