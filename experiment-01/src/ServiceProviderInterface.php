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
interface ServiceProviderInterface
{
    /**
     * Returns an array of services names.
     *
     * Services names can be retrieved with container `get()` / `has()` and be passed as first param
     * to `createService()`
     *
     * @return string[]
     * @see ContainerInterface::get()
     * @see ContainerInterface::has()
     */
    public function providedServices();

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
    );
}
