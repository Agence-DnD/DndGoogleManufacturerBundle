<?php

declare(strict_types=1);

namespace Dnd\Bundle\GoogleManufacturerBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class DndGoogleManufacturerExtension
 *
 * @package   Dnd\Bundle\GoogleManufacturerBundle\DependencyInjection
 * @author    Agence Dn'D <contact@dnd.fr>
 * @copyright 2020 Agence Dn'D
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.dnd.fr/
 */
class DndGoogleManufacturerExtension extends Extension
{
    /**
     * {@inheritdoc}
     *
     * @param mixed[]          $configs
     * @param ContainerBuilder $container
     *
     * @return void
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        /** @var Loader\YamlFileLoader $loader */
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('array_converters.yml');
        $loader->load('controllers.yml');
        $loader->load('job_constraints.yml');
        $loader->load('job_defaults.yml');
        $loader->load('job_providers.yml');
        $loader->load('jobs.yml');
        $loader->load('steps.yml');
        $loader->load('renderers.yml');
        $loader->load('writers.yml');
    }
}
