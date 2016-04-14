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
    public function serviceFactories()
    {
        return [
            'hello-world' => [$this, 'helloWorld']
        ];
    }

    /**
     * @inheritdoc
     */
    public function helloWorld(
        ContainerInterface $container,
        callable $previous = null
    ) {
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
