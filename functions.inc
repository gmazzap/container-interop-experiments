<?php
/*
 * This file is part of the container-interop-experiments package.
 *
 * (c) Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GM\InteropExperiments;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Server;

/**
 * Main application callback.
 *
 * Works with anything that implements Container Interop.
 *
 * @param \Interop\Container\ContainerInterface $container
 */
function main(ContainerInterface $container)
{
    try {

        Server::createServerfromRequest(
            function (Request $request, Response $response) use ($container) {

                /** @var \Mustache_Engine $engine */
                $engine = $container->get('mustache.engine');
                /** @var \GM\InteropExperiments\HelloWorld\HelloWorld $hello */
                $hello = $container->get('hello-world');

                $uri = $request->getUri();
                $baseUrl = $uri->withQuery('');

                parse_str($uri->getQuery(), $vars);

                $lang = empty($vars['lang'])
                    ? 'en'
                    : filter_var($vars['lang'], FILTER_SANITIZE_STRING);

                $response->getBody()->write($engine->render('index', [
                    'greeting'  => $hello->sayHello($lang),
                    'language'  => $hello->languageName($lang),
                    'title'     => ucwords(str_replace(['-', '/'], [' ', ''], $uri->getPath())),
                    'languages' => $hello->supportedLanguages(),
                    'base_url'  => (string)$baseUrl,
                    'index_url' => (string)$baseUrl->withPath(''),
                ]));

                return $response;
            },
            ServerRequestFactory::fromGlobals(),
            new HtmlResponse('')
        )->listen();
    } catch (\Exception $e) {
        $env = getenv('ENVIRONMENT') ? : 'development';

        global $message, $trace;
        $message = $env === 'production' ? 'Error' : $e->getMessage();

        if (headers_sent()) {
            die($message);
        }

        header('HTTP/1.0 Internal Server Error', true, 500);

        if ($env !== 'production') {
            $trace = $e->getTraceAsString();
            include 'templates/error.php';
        }
    }
}
