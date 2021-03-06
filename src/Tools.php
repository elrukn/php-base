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
namespace Teon\Base;



/*
 * Class definition - LEGACY, USE Stdlib\* INSTEAD
 */
class Tools
{



    /*
     * Generate random string - LEGACY ALIAS
     *
     * @param    int      Desired string length
     * @return   string   Random string
     */
    static function generateRandomString ($length=32)
    {
        trigger_error("This class is deprecated. Use \Teon\Base\Stdlib\* instead.", E_USER_DEPRECATED);
        return Stdlib\StringUtils::generateRandomString($length);
    }



    /*
     * Get only last part of namespaced class name - LEGACY ALIAS
     *
     * @param    mixed    Full namespaced class name or object
     * @return   string   Last part of namespaced class name
     */
    static function getShortClassName ($classNameFullOrObject)
    {
        trigger_error("This class is deprecated. Use \Teon\Base\Stdlib\* instead.", E_USER_DEPRECATED);
        return Stdlib\ClassUtils::getShortClassName($classNameFullOrObject);
    }
}
