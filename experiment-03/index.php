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

use function GM\InteropExperiments\main;

$basedir = dirname(__DIR__);
require_once $basedir.'/vendor/autoload.php';
require_once $basedir.'/functions.inc';

// Instantiate container, then service providers then register all of them. Quite Easy :)
$container = new Container();
$providers = [
    new MustacheServiceProvider(),
    new HelloWorldServiceProvider(),
];
array_walk($providers, [$container, 'useProvider']);

main($container);

unset($basedir, $providers, $container);
