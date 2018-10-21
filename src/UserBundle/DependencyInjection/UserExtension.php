<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 27/09/2018
 * Time: 17:35
 */

namespace UserBundle\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * @package UserBundle\DependencyInjection
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class UserExtension extends Extension
{

    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../../../app/config'));
        $loader->load('services.yml');

        $container->setParameter('vs_user_bundle.login_redirect', $config['login_redirect']);
    }

}
