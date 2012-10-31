<?php

/*
 * This file is part of the RuudkMollieBundle package.
 *
 * (c) Ruud Kamphuis <ruudk@mphuis.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ruudk\MollieBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class RuudkMollieExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        if (isset($config['partner_id'])) {
            $container->setParameter('ruudk_mollie.partner_id', $config['partner_id']);
        }

        if (isset($config['profile_key'])) {
            $container->setParameter('ruudk_mollie.profile_key', $config['profile_key']);
        }

        if (isset($config['testmode'])) {
            $container->setParameter('ruudk_mollie.testmode', $config['testmode']);
        }

        if (isset($config['buzz_client'])) {
            $container->setParameter('ruudk_mollie.buzz_client.class', $config['buzz_client'] == 'curl' ? 'Buzz\Client\Curl' : 'Buzz\Client\FileGetContents');
        }
    }
}
