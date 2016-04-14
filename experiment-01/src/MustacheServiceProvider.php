<?php
/*
 * This file is part of the container-interop-experiments package.
 *
 * (c) Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GM\InteropExperiments\Exp01;

use Interop\Container\ContainerInterface;


/**
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @package container-interop-experiments
 */
final class MustacheServiceProvider implements ServiceProviderInterface
{
    private static $services = [
        'mustache.loader', // \Mustache_Loader
        'mustache.engine' // \Mustache_Engine
    ];

    /**
     * @inheritdoc
     */
    public function providedServices()
    {
        return self::$services;
    }

    /**
     * Service factory.
     *
     * It receives a service name, the container and have to return an instance of the service.
     * The `$previous` callable, when provided, can be used to return an instance of the service
     * that is already stored in the container.
     *
     * @param string                                $serviceName
     * @param \Interop\Container\ContainerInterface $container
     * @param callable                              $previous
     * @return mixed
     */
    public function createService(
        $serviceName,
        ContainerInterface $container,
        callable $previous = null
    ) {
        if (! is_string($serviceName) || ! in_array($serviceName, self::$services)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '"%s" is not a valid service name for %s',
                    is_string($serviceName) ? $serviceName : gettype($serviceName),
                    __CLASS__
                )
            );
        }

        switch ($serviceName) {

            case 'mustache.loader' :
                $path = $container->has('templates-path')
                    ? $container->get('templates-path')
                    : dirname(dirname(__DIR__)).'/templates';

                return new \Mustache_Loader_FilesystemLoader($path);

            case 'mustache.engine' :
                return new \Mustache_Engine([
                    'escape' => function ($value) {
                        return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
                    },
                    'loader' => $container->get('mustache.loader')
                ]);
        }
    }
}
