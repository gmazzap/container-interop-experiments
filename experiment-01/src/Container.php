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
use Pimple\Container as PimpleContainer;
use GM\InteropExperiments\Exception;

/**
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @package container-interop-experiments
 */
final class Container implements ContainerInterface
{
    /**
     * @var \Pimple\Container
     */
    private $container;

    /***
     * @param \Pimple\Container|null $container
     */
    public function __construct(PimpleContainer $container = null)
    {
        $this->container = $container ? : new PimpleContainer();
    }

    /**
     * @inheritdoc
     */
    public function get($id)
    {
        if (! $this->has($id)) {
            throw new Exception\NotFoundException();
        }

        try {
            return $this->container->offsetGet($id);
        } catch (\Exception $e) {
            throw new Exception\ContainerException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @inheritdoc
     */
    public function has($id)
    {
        return $this->container->offsetExists($id);
    }

    /**
     * Used to add a (proposed) Container Interop service provider
     *
     * @param \GM\InteropExperiments\Exp01\ServiceProviderInterface $serviceProvider
     * @return \Interop\Container\ContainerInterface
     */
    public function useProvider(ServiceProviderInterface $serviceProvider)
    {
        $services = $serviceProvider->providedServices();

        array_walk($services, function ($service) use ($serviceProvider) {
            $this->has($service)
                ? $this->extendService($service, $serviceProvider)
                : $this->addService($service, $serviceProvider);
        });

        return $this;
    }

    /**
     * @param string                                                $service
     * @param \GM\InteropExperiments\Exp01\ServiceProviderInterface $serviceProvider
     */
    private function extendService($service, ServiceProviderInterface $serviceProvider)
    {
        $this->container->extend($service, function () use ($service, $serviceProvider) {
            $serviceProvider->createService($service, $this, function () use ($service) {
                return $this->container->offsetGet($service);
            });
        });
    }

    /**
     * @param string                                                $service
     * @param \GM\InteropExperiments\Exp01\ServiceProviderInterface $serviceProvider
     */
    private function addService($service, ServiceProviderInterface $serviceProvider)
    {
        $this->container->offsetSet($service, function () use ($service, $serviceProvider) {
            return $serviceProvider->createService($service, $this);
        });
    }
}
