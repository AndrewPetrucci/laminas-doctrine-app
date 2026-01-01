<?php

namespace Application\View\Helper\Factory;

use Application\View\Helper\RoutingTreeHelper;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class RoutingTreeHelperFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $app = $container->get('Application');
        return new RoutingTreeHelper($app);
    }
}
