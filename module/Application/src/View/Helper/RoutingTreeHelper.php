<?php

namespace Application\View\Helper;

use Application\Helper\RouteExclusions;
use Laminas\View\Helper\AbstractHelper;
use Laminas\ServiceManager\ServiceLocatorInterface;

class RoutingTreeHelper extends AbstractHelper
{
    private $application;

    public function __construct($application)
    {
        $this->application = $application;
    }

    public function __invoke()
    {
        return $this->getRoutingTree();
    }

    public function getRoutingTree()
    {
        $serviceManager = $this->application->getServiceManager();
        $config = $serviceManager->get('config');
        $routes = $config['router']['routes'] ?? [];

        $html = '<ul style="list-style-type: none; padding-left: 0;">';
        
        foreach ($routes as $name => $routeConfig) {
            if (RouteExclusions::isExcluded($name)) {
                continue;
            }
            
            $order = $routeConfig['options']['order'] ?? 99;
            $title = ucfirst(str_replace('-', ' ', $name));
            
            // Use the URL view helper to generate proper route URLs
            try {
                $url = $this->view->url($name);
            } catch (\Exception $e) {
                // Fallback to route option if URL generation fails
                $url = $routeConfig['options']['route'] ?? '/';
            }
            
            $html .= sprintf(
                '<li style="margin: 5px 0;">
                    <a href="%s" style="text-decoration: none; color: #0074D9; font-weight: 500;">
                        📄 %s
                    </a>
                </li>',
                htmlspecialchars($url),
                htmlspecialchars($title)
            );
        }
        
        $html .= '</ul>';
        return $html;
    }
}
