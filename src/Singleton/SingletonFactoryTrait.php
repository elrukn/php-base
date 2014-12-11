<?php
/*
 * Teon PHP Base - Singleton Trait
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
namespace Teon\Base\Singleton;



/*
 * TRAIT: Singleton
 *
 * Provides singleton functionality to be embedded into class
 *
 * Usage:
 *
 *     This is a simple trait to convert your class/object into
 *     singleton.
 */
trait SingletonFactoryTrait
{





    /*
     * Get instance - this is actually a factory, but it does not matter here
     */
    public static function getInstance ()
    {
        return self::factory();
    }



    /*
     * Creates a new object instance
     */
    public static function factory ()
    {
        static $instance;

        if (NULL === $instance) {
            $instance = new self();
        }

        return $instance;
    }
}
