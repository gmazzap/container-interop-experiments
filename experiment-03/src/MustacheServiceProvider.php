<?php
/*
 * This file is part of the container-interop-experiments package.
 *
 * (c) Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GM\InteropExperiments\Exp03;

use Interop\Container\ContainerInterface;


/**
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @package container-interop-experiments
 */
final class MustacheServiceProvider implements ServiceProviderInterface
{
    /**
     * @inheritdoc
     */
    public function serviceFactories()
    {
        return [
            'mustache.loader' => function ($container, $previous = null) {
                return $this->loader($container, $previous);
            },
            'mustache.engine' => function ($container, $previous = null) {
                return $this->engine($container, $previous);
            },
        ];
    }

    /**
     * Service factory.
     *
     * It receives a service name, the container and have to return an instance of the service.
     * The `$previous` callable, when provided, can be used to return an instance of the service
     * that is already stored in the container.
     *
     * @param \Interop\Container\ContainerInterface $container
     * @param callable                              $previous
     * @return mixed
     */
    private function loader(
        ContainerInterface $container,
        callable $previous = null
    ) {
        if ($previous) {
            return $previous();
        }

        $path = $container->has('templates-path')
            ? $container->get('templates-path')
            : dirname(dirname(__DIR__)).'/templates';

        return new \Mustache_Loader_FilesystemLoader($path);
    }

    /**
     * Service factory.
     *
     * It receives a service name, the container and have to return an instance of the service.
     * The `$previous` callable, when provided, can be used to return an instance of the service
     * that is already stored in the container.
     *
     * @param \Interop\Container\ContainerInterface $container
     * @param callable                              $previous
     * @return mixed
     */
    private function engine(
        ContainerInterface $container,
        callable $previous = null
    ) {
        if ($previous) {
            return $previous();
        }

        return new \Mustache_Engine([
            'escape' => function ($value) {
                return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
            },
            'loader' => $container->get('mustache.loader')
        ]);
    }
}
