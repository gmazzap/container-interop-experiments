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

use Interop\Container\ContainerInterface;


/**
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @package container-interop-experiments
 */
interface ServiceFactoryInterface
{
    /**
     * @return string
     */
    public function serviceName();

    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param callable|null                         $previous
     * @return mixed
     */
    public function factory(ContainerInterface $container, callable $previous = null);
}
