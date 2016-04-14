<?php
/*
 * This file is part of the container-interop-experiments package.
 *
 * (c) Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GM\InteropExperiments\Exp02;

/**
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @package container-interop-experiments
 */
interface ServiceProviderInterface
{
    /**
     * Returns an array of service factories objects.
     *
     * By calling `factory()` method on each of those objects is possible to get an in instance
     * of the service.
     * By calling `factory()` is possible to get the service name, that can be used in container
     * `get()` and `has()` methods.
     *
     * @return \GM\InteropExperiments\Exp02\ServiceFactoryInterface[]
     *
     * @see \GM\InteropExperiments\Exp02\ServiceFactoryInterface::factory()
     * @see \GM\InteropExperiments\Exp02\ServiceFactoryInterface::name()
     * @see \Interop\Container\ContainerInterface::get()
     * @see \Interop\Container\ContainerInterface::has()
     */
    public function serviceFactories();
}
