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

use GM\InteropExperiments\HelloWorld\HelloWorld;
use Interop\Container\ContainerInterface;

/**
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @package container-interop-experiments
 */
final class HelloWorldServiceProvider implements ServiceProviderInterface
{
    /**
     * @inheritdoc
     */
    public function providedServices()
    {
        return ['hello-world'];
    }

    /**
     * @inheritdoc
     */
    public function createService(
        $serviceName,
        ContainerInterface $container,
        callable $previous = null
    ) {
        if ($serviceName !== 'hello-world') {
            throw new \InvalidArgumentException(
                sprintf(
                    '"%s" is not a valid service name for %s',
                    is_string($serviceName) ? $serviceName : gettype($serviceName),
                    __CLASS__
                )
            );
        }

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
