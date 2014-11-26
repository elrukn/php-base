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
namespace Teon\Base\Entity;



/*
 * Class definition
 */
abstract class AbstractEntityCached
{



    /*
     * Id
     */
    protected $_id = false;



    /*
     * Factory an entity object with given ID
     *
     * @param    int                      ID of entity to instantiate
     * @return   TeamDoe\Core\Something   Entity object
     * @throws   TeamDoe\Core\Exception   If organization is not found
     */
    public static function factory ($id)
    {
        // Which class to instantiate
        $entityClassName = get_called_class();

        // Get object cache registry
        $ObjectRegistry  = \Teon\ObjectRegistry\ObjectRegistry::getInstance();

        // If this object already in cache, use that
        if ($ObjectRegistry->exists($entityClassName, $id)) {
            return $ObjectRegistry->get($entityClassName, $id);
        }

        // If not, instantiate new, store in object registry and return it
        $Object = new $entityClassName($id);
        $ObjectRegistry->store($Object);
        return $Object;
    }



    /*
     * Constructor
     *
     * @param    int|string   Unique entity ID
     * @return   void
     */
    public function __construct ($id)
    {
        $this->_id = $id;
    }



    /*
     * Get unique ID of current entity
     *
     * @return   int|string   Unique entity ID
     */
    public function getId ()
    {
        return $this->_id;
    }
}
