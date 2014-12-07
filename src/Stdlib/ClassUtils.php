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
class ClassUtils
{



    /*
     * Get only last part of namespaced class name
     *
     * @param    mixed    Full namespaced class name or object
     * @return   string   Last part of namespaced class name
     */
    static function getBaseClassName ($fullClassNameOrObject)
    {
        $reflect = new \ReflectionClass($fullClassNameOrObject);
        return $reflect->getShortName();
    }

    static function getShortClassName ($fullClassNameOrObject)
    {
        trigger_error("This method is deprecated. Use getBaseClassName() instead.", E_USER_DEPRECATED);
        return self::getBaseClassName($fullClassNameOrObject);
    }



    /*
     * Get only relevant part of MVC controller class name
     *
     * @param    mixed    Full namespaced class name or object
     * @return   string   Last part of namespaced class name
     */
    static function getBaseControllerName ($fullClassNameOrObject)
    {
        $baseName = self::getBaseClassName($fullClassNameOrObject);
        return preg_replace('/Controller$/', '', $baseName);
    }



    /*
     * Get public controller class name (by standard ZF2 routing scheme)
     *
     * Converts 'CamelCaseController' into 'camel-case'
     *
     * @param    mixed    Full namespaced class name or object
     * @return   string   Last part of namespaced class name
     */
    static function getPublicControllerName ($fullClassNameOrObject)
    {
        $baseName = self::getBaseControllerName($fullClassNameOrObject);

        return strtolower(preg_replace('/([A-Z])/', '-$1', lcfirst($baseName)));
    }
}
