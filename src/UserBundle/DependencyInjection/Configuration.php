<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 27/09/2018
 * Time: 17:34
 */

namespace UserBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @package UserBundle\DependencyInjection
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('user');

        $rootNode
            ->children()
                ->scalarNode('login_redirect')->end()
            ->end()
        ;

        return $treeBuilder;
    }

}