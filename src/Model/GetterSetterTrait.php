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

use Teon\Base\Entity\AbstractEntityCached;


/*
 * Trait definition
 */
trait   GetterSetterTrait
{



    /**
     * May be defined: getter/setter entity property name
     *
     * Which object property name contains ZF Db Row object. By default
     * 'entity' is assumed.
     *
     * @var   string
     */
    //protected $_getterSetterEntityProperty = 'entity';



    /**
     * May be defined: getter/setter entity class/interface
     *
     * Check if entity is actually instance of this class/interface. Throw error if
     * entity property is of another object. Setting this to false disabled this check
     *
     * @var   string|boolean false
     */
    //protected $_getterSetterEntityClass = '\Zend\Db\RowGateway\RowGatewayInterface';



    /**
     * May be defined: getter/setter access map
     *
     * Example:
     *     array(
     *         'propertyName1' = array('read' => true,  'write' => false),
     *         'propertyName2' = array('read' => false, 'write' => false),
     *         'propertyName3' = array('read' => true,  'write' => true ),
     *         ...
     *     );
     *
     * @var   array
     */
    //protected $_getterSetterAccessMap;



    /**
     * May be defined: default read access permission
     *
     * @var   boolean
     */
    //protected $_getterSetterDefaultReadAllow = true;   // Accessing properties is allowed by default



    /**
     * May be defined: default write access permission
     *
     * @var   boolean
     */
    //protected $_getterSetterDefaultWriteAllow = false;   // Setting properties is denied by default



    /**
     * May be defined: call explicit getter if exists
     *
     * If user goes about echo $MyObj->prop1, and $MyObj's class uses this GetterSetterTrait,
     * and user has defined MyObj::getProp1() method, this method is used instead of direcly
     * getting data from entity object.
     *
     * Flow without this feature:
     * - call to get prop1 ($MyObj->prop1) is issued
     * - as $MyObj->prop1 is not found, __get magic method is called, from this trait
     * - __get checks: if entity property exists
     * - __get checks: if there is read access to it
     * - __get returns value of entity property
     *
     * Flow WITH this feature:
     * - call to get prop1 ($MyObj->prop1) is issued
     * - as $MyObj->prop1 is not found, __get magic method is called, from this trait
     * - __get checks: if entity property exists
     * - __get checks: if there is a explicit getter defined (called getProp1)
     * - if yes: __get calls getProp1() and returns returned value from that function (no access is checked)
     * - if not: continue
     * - __get checks: if there is read access to it
     * - __get returns value of entity property
     *
     * @var   boolean
     */
    //protected $_getterSetter_useExplicitlyDefinedGetterIfExists = true;   // Yes by default



    /**
     * May be defined: call explicit setter if exists
     *
     * For description see _getterSetterUseExplicitlyDefinedGetterIfExists,
     * it is exactly analoguous
     *
     * @var   boolean
     */
    //protected $_getterSetter_useExplicitlyDefinedSetterIfExists = true;   // Yes by default



    /**
     * Get all entity properties
     *
     * @return   arrray
     */
    public function getEntityData ()
    {
        $Entity = $this->___getterSetterGetEntity();
        return $Entity->toArray();
    }



    /**
     * Magic method: get entity property
     *
     * Returns entity property
     *
     * @param    string   Property name to get
     * @throws   Exception
     * @return   mixed
     */
    public function __get ($name)
    {
        $Entity = $this->___getterSetterGetEntity();

        // Check existance
        if (!$Entity->offsetExists($name)) {
            throw new Exception("Model property does not exist: $name");
        }

        // Is there explicitly defined getter?
        if (
            (
                !isset($_getterSetter_useExplicitlyDefinedGetterIfExists)
                ||
                (true == $_getterSetter_useExplicitlyDefinedGetterIfExists)
            )
            &&
            method_exists($this, 'get'.ucfirst($name))
        ) {
            // Yes, use that
            return call_user_func(array($this, 'get'.ucfirst($name)));
        }

        // Check access
        if (!$this->___getterSetterCheckReadAccess($name)) {
            throw new Exception("Model property read access denied: $name");
        }

        // Return property value
        return $Entity->{$name};
    }



    /**
     * Magic method: check if entity property exists
     *
     * @param    string   Property name to check
     * @return   bool
     */
    public function __isset ($name)
    {
        $Entity = $this->___getterSetterGetEntity();

        return $Entity->offsetExists($name);
    }



    /**
     * Magic method: set entity property
     *
     * Returns entity property
     *
     * @param    string   Property name to write to
     * @param    string   Value to write
     * @throws   Exception
     * @return   void
     */
    public function __set ($name, $value)
    {
        $Entity = $this->___getterSetterGetEntity();

        // Check existance
        if (!$Entity->offsetExists($name)) {
            throw new Exception("Model property does not exist: $name");
        }

        // Is there explicitly defined setter?
        if (
            (
                !isset($_getterSetter_useExplicitlyDefinedSetterIfExists)
                ||
                (true == $_getterSetter_useExplicitlyDefinedSetterIfExists)
            )
            &&
            method_exists($this, 'set'.ucfirst($name))
        ) {
            // Yes, use that
            return call_user_func(array($this, 'set'.ucfirst($name)), $value);
        }

        // Check access
        if (!$this->___getterSetterCheckWriteAccess($name)) {
            throw new Exception("Model property write access denied: $name");
        }

        // Store property
        $Entity->{$name} = $value;
        $Entity->save();
    }



    /**
     * Get entity object
     *
     * Determines entity object name, returns it if it exists
     *
     * @throws   Exception   If entity object is not found
     * @return   \Zend\Db\Row\RowGateway
     */
    protected function ___getterSetterGetEntity ()
    {
        // Determine entity name
        $entityName = $this->___getterSetterGetEntityPropertyName();

        // Check if entity exists
        if (!isset($this->{$entityName})) {
            throw new Exception("Entity property is not set: $entityName");
        }

        // Check if entity is of proper class
        $requestedClass = $this->___getterSetterGetEntityClass();
        if (false !== $requestedClass) {
            if (!($this->{$entityName} instanceof $requestedClass)) {
                throw new Exception("Entity is not an instance of requested class: $requestedClass");
            }
        }

        return $this->{$entityName};
    }



    /**
     * Determine entity property name to use
     *
     * @return   string
     */
    protected function ___getterSetterGetEntityPropertyName ()
    {
        if (isset($this->_getterSetterEntityProperty)) {
            return $this->_getterSetterEntityProperty;
        } else {
            return 'entity';
        }
    }



    /**
     * Get entity class to check agains
     *
     * Determines entity object class to check against.
     *
     * @return   string|boolean(false)
     */
    protected function ___getterSetterGetEntityClass ()
    {
        // Determine entity name
        if (isset($this->_getterSetterEntityClass)) {
            return $this->_getterSetterEntityClass;
        } else {
            return '\Zend\Db\RowGateway\RowGatewayInterface';
        }
    }



    /**
     * Check READ access to the property
     *
     * @param    string   Property name to check access for
     * @return   bool
     */
    protected function ___getterSetterCheckReadAccess ($name)
    {
        return $this->___getterSetterCheckAccess('read', $name);
    }



    /**
     * Check WRITE access to the property
     *
     * @param    string   Property name to check access for
     * @return   bool
     */
    protected function ___getterSetterCheckWriteAccess ($name)
    {
        return $this->___getterSetterCheckAccess('write', $name);
    }



    /**
     * Check GENERAL access to the property
     *
     * @param    string   Type of access to check for
     * @param    string   Property name to check access for
     * @return   bool
     */
    protected function ___getterSetterCheckAccess ($type, $name)
    {
        // Check for explicit definition
        if (isset($this->_getterSetterAccessMap)) {
            if (array_key_exists($name, $this->_getterSetterAccessMap)) {
                if (array_key_exists($type, $this->_getterSetterAccessMap[$name])) {
                    return $this->_getterSetterAccessMap[$name][$type];
                }
            }
        }

        // Check for default privilege setting
        $typeUcf = ucfirst($type);
        $defaultAccessPropertyName = "_getterSetterDefault{$typeUcf}Allow";
        if (isset($this->{$defaultAccessPropertyName})) {
            return $this->{$defaultAccessPropertyName};
        }

        // Otherwise return default sensible answer (write no, read yes)
        if ('read' == $type) {
            return true;
        } else {
            return false;
        }
    }
}
