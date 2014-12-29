<?php
/*
 * Teon PHP Base
 *
 * Copyright (C) 2012-2014 Teon d.o.o.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */



/*
 * Namespace definition
 */
namespace Teon\Base\Stdlib;



/*
 * Class definition
 */
class RouteUtils
{



    /*
     * Generate route config for /uriPrefix/:action route
     *
     * @param    string   Uri prefix, without leading forward slash. If empty string, controller name is converted to Index
     * @param    string   Optional default controller. If omitted, determined from uriPrefix (dashed-uri to CamelCase conversion is applied)
     * @param    string   Optional default action, 'index' by default
     * @return   array    Generated route configuration
     */
    public static function generateRouteWithAction ($uriPrefix, $defaultController=NULL, $defaultAction='index')
    {
        // Determine default controller name, if not present
        if (NULL === $defaultController) {
            $defaultController = StringUtils::convertDashToCamelCase($uriPrefix);
        }

        // Generate route
        return array(
            'type'          => 'Segment',
            'options'       => array(
                'route'         => '/'. $uriPrefix .'[/:action][/]',
                'constraints'   => array(
                    'action'        => '[a-zA-Z][a-zA-Z0-9-]*',
                ),
                'defaults'      => array(
                    'controller'    => $defaultController,
                    'action'        => $defaultAction,
                ),
            ),
            'may_terminate' => true,
            'child_routes'  => array(),
        );
    }

    public static function appendRouteWithAction ($existingRouteConfig, $uriPrefix, $defaultController=NULL, $defaultAction='index')
    {
        return array_merge($existingRouteConfig, array($uriPrefix => self::generateRouteWithAction($uriPrefix, $defaultController, $defaultAction)));
    }



    /*
     * Generate route config for /uriPrefix/:action/:id route
     *
     * @param    string   Uri prefix, without leading forward slash
     * @param    string   Optional default controller. If omitted, determined from uriPrefix (dashed-uri to CamelCase conversion is applied)
     * @param    string   Optional default action, 'index' by default
     * @return   array    Generated route configuration
     */
    public static function generateRouteWithActionAndId ($uriPrefix, $defaultController=NULL, $defaultAction='index')
    {
        // Get template from 'parent' function
        $routeConfig = self::generateRouteWithAction($uriPrefix, $defaultController, $defaultAction);

        // Add/adjust settings
        $routeConfig['options']['route']             = '/'. $uriPrefix .'[/:action][/:id][/]';
        $routeConfig['options']['constraints']['id'] = '[1-9][0-9]*';

        return $routeConfig;
    }

    public static function appendRouteWithActionAndId ($existingRouteConfig, $uriPrefix, $defaultController=NULL, $defaultAction='index')
    {
        return array_merge($existingRouteConfig, array($uriPrefix => self::generateRouteWithActionAndId($uriPrefix, $defaultController, $defaultAction)));
    }
}
