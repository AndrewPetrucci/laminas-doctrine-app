<?php

declare(strict_types=1);

namespace Application\Helper;

class RouteExclusions
{
    /**
     * Routes to exclude from navigation and other view helpers
     */
    public const EXCLUDED_ROUTES = [
        'application',
        'doctrine_orm_module_yuml',
    ];

    /**
     * Get the list of routes to exclude
     */
    public static function getExcludedRoutes(): array
    {
        return self::EXCLUDED_ROUTES;
    }

    /**
     * Check if a route should be excluded
     */
    public static function isExcluded(string $routeName): bool
    {
        return in_array($routeName, self::EXCLUDED_ROUTES, true);
    }
}
