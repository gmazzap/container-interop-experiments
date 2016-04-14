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
final class MustacheServiceFactory implements ServiceFactoryInterface
{
    const NAME = 'mustache.engine';

    /**
     * @return string
     */
    public function serviceName()
    {
        return self::NAME;
    }

    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param callable|null                         $previous
     * @return mixed
     */
    public function factory(ContainerInterface $container, callable $previous = null)
    {
        if ($previous) {
            return $previous(); // we don't bother create another instance if there's already one
        }

        $path = $container->has('templates-path')
            ? $container->get('templates-path')
            : dirname(dirname(__DIR__)).'/templates';

        $loader = $container->has('mustache.loader')
            ? $container->get('mustache.loader')
            : new \Mustache_Loader_FilesystemLoader($path);

        $escape = $container->has('mustache.escape')
            ? $container->get('mustache.escape')
            : function ($value) {
                return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
            };

        return new \Mustache_Engine(['escape' => $escape, 'loader' => $loader]);
    }
}
