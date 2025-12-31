<?php

declare(strict_types=1);

namespace Application\View\Helper;

use Laminas\View\Helper\AbstractHelper;
use Laminas\Mvc\Application;

class NavbarHelper extends AbstractHelper
{
    private $application;
    
    public function __construct(Application $application)
    {
        $this->application = $application;
    }
    
    public function __invoke()
    {
        return $this->getNavigation();
    }
    
    public function getNavigation(): array
    {
        $serviceManager = $this->application->getServiceManager();
        $config = $serviceManager->get('config');
        $routes = $config['router']['routes'] ?? [];
        
        // Build navigation from routes
        $nav = [];
        $routesToExclude = ['application', 'doctrine_orm_module_yuml']; // Exclude these from nav
        
        foreach ($routes as $routeName => $routeConfig) {
            if (in_array($routeName, $routesToExclude)) {
                continue;
            }
            
            $route = $routeConfig['options']['route'] ?? '';
            // Convert route names to readable titles
            $title = ucfirst(preg_replace('/[-_]/', ' ', $routeName));
            $order = $routeConfig['options']['order'] ?? 999; // Default order if not set
            
            $nav[] = [
                'title' => $title,
                'route' => $route,
                'name' => $routeName,
                'order' => $order
            ];
        }
        
        // Sort navigation by order
        usort($nav, function($a, $b) {
            return $a['order'] <=> $b['order'];
        });
        
        return $nav;
    }
}
