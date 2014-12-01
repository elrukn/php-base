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
namespace Teon\Base\Validate;



/*
 * Class definition
 */
class Syntax
{



    /*
     * Validate alphanumeric string
     *
     * @param    mixed   Value to validate
     * @return   bool    True if valid, false if not
     */
    public static function alphanumeric ($value)
    {
        $res = preg_match('/^[0-9a-zA-Z]+$/', $value);
        if (false === $res) {
            throw new Exception("Unable to verify alphanumericy: $value");
        } elseif (0 == $res) {
            return false;
        } else {
            return true;
        }
    }



    /*
     * Validate email address
     *
     * @param    mixed   Value to validate
     * @return   bool    True if valid, false if not
     */
    public static function emailAddress ($value)
    {
        $v = new \Zend\Validator\EmailAddress();
        return $v->isValid($value);
    }



    /*
     * Validate ID syntax
     *
     * Alias function for numericId()
     *
     * @param    mixed   Value to validate
     * @return   bool    True if valid, false if not
     */
    public static function id ($value)
    {
        return $this->numericId();
    }



    /*
     * Validate numeric ID syntax
     *
     * @param    mixed   Value to validate
     * @return   bool    True if valid, false if not
     */
    public static function numericId ($value)
    {
        // Check type and characters
        if (!is_int($value)
            &&
            !(is_string($value) && preg_match('/^[0-9]+$/', $value))
        ) {
            return false;
        }

        // Check range
        if ($value > 0) {
            return false;
        }

        // Valid
        return true;
    }
}
