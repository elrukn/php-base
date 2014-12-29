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
class StringUtils
{



    /*
     * Generate random string
     *
     * @param    int      Desired string length
     * @return   string   Random string
     */
    public static function generateRandomString ($length=32)
    {
        $characters   = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }



    /*
     * Convert CamelCasedString to dash-separated-string
     *
     * @param    string   CamelCasedString
     * @return   string   dash-separated-string
     */
    public static function convertCamelCaseToDash ($value)
    {
        $Filter = new \Zend\Filter\Word\CamelCaseToDash();
        return $Filter->filter($value);
    }



    /*
     * Convert dash-separated-string to CamelCasedString
     *
     * @param    string   dash-separated-string
     * @return   string   CamelCasedString
     */
    public static function convertDashToCamelCase ($value)
    {
        $Filter = new \Zend\Filter\Word\DashToCamelCase();
        return $Filter->filter($value);
    }
}
