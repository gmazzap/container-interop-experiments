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

/**
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @package container-interop-experiments
 */
interface ServiceProviderInterface
{
    /**
     * Returns an array of service factories in form of callback.
     *
     * The callback will receive 3 arguments: service name, an instance of container interface
     * and optionally a callback that return an instance of the previous value for the service.
     *
     * @return callable[]
     */
    public function serviceFactories();
}
