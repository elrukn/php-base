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



    /*
     * Sanitize string to be acceptable as filename
     *
     * Initial implementation source:
     * http://stackoverflow.com/questions/2668854/sanitizing-strings-to-make-them-url-and-filename-safe
     *
     * @param    string   String to sanitize
     * @param    bool     Force lower case?
     * @param    bool     Force anal (hm, should this be spelled "rape" instead?:)
     * @return   string
     */
    public static function sanitizeForFilename ($string, $forceLowercase=false, $forceAnal=false)
    {
        // Perform the cleaning
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
                       "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
                       "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
//        $clean = preg_replace('/\s+/', "-", $clean);   // We do not replace spaces
        $clean = preg_replace('/\s+/', " ", $clean);   // We do not replace spaces, only trim them to one
        $clean = ($forceAnal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
        $clean = ($forceLowercase) ? mb_strtolower($clean, 'UTF-8') : $clean;

        return $clean;
    }
}
