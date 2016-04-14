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

use GM\InteropExperiments\HelloWorld\HelloWorld;
use Interop\Container\ContainerInterface;


/**
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @package container-interop-experiments
 */
final class HelloWorldServiceFactory implements ServiceFactoryInterface
{
    const SERVICE_NAME = 'hello-world';

    /**
     * @return string
     */
    public function serviceName()
    {
        return self::SERVICE_NAME;
    }

    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param callable|null                         $previous
     * @return mixed
     */
    public function factory(ContainerInterface $container, callable $previous = null)
    {
        $defLang = $container->has('hello-world.deflang')
            ? $container->get('hello-world.deflang')
            : 'en';

        $oldInstance = $previous ? $previous() : null;

        // if existent instance has the same default language, no need to build another one
        if ($oldInstance instanceof HelloWorld && $oldInstance->defaultLanguage() === $defLang) {
            return $oldInstance;
        }

        return new HelloWorld($defLang);
    }
}
