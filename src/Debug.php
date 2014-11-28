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
 * Class definition
 */
class Debug
{



    /*
     * Returns ID number of given object
     *
     * Extracts the top line of var_dump for given object
     *
     * @param    object   Object of interest
     * @return   int      Object ID
     */
    static function getObjectId ($object)
    {
        // Get dump content
        ob_start();
        var_dump($object);
        $dumpContent = ob_get_clean();

        // Extract first line, and from first line the object ID
        $firstLine   = strtok($dumpContent, "\n");
        preg_match('/[^#]+#([0-9]+)/', $firstLine, $m);
        $id = $m[1];

        // Return the ID
        return $id;
    }
}
