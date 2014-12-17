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
namespace Teon\Base\Model;



/*
 * Trait definition
 */
trait   GetterSetterMethodTrait
{



    /**
     * Required parent trait
     */
    use GetterSetterTrait;



    /**
     * Magic method: call (used for getPropName() and setPropName())
     *
     * Calls either getter or setter
     *
     * @param    string   Property name to get
     * @throws   Exception
     * @return   mixed
     */
    public function __call ($name, $args)
    {
        if (preg_match('/(get|set)(.+)$/', $name, $m)) {
            $action = $m[1];
            $propertyName = lcfirst($m[2]);
            array_unshift($args, $propertyName);
            return call_user_func_array(array($this, "__$action"), $args);
        }

        // Check if parent defined __call - use that in non ^(get|set) case
        if (is_callable('parent::__call')) {
            return parent::__call($name, $args);
        }

        // Else output error
        trigger_error("Unefined method: $name", E_USER_ERROR);
    }
}
