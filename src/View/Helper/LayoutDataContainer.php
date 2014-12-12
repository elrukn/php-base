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
namespace Teon\Base\View\Helper;



/*
 * Class definition
 */
class        LayoutDataContainer
//extends      \Zend\Stdlib\ArrayObject
implements   \Zend\View\Helper\HelperInterface
{



    /**
     * Data storage facility
     *
     * @var array
     */
    protected $storage = array();



    /**
     * View object instance
     *
     * @var Renderer
     */
    protected $view = null;



    /**
     * Set the View object
     *
     * @param  Renderer $view
     * @return AbstractHelper
     */
    public function setView(\Zend\View\Renderer\RendererInterface $view)
    {
        $this->view = $view;
        return $this;
    }



    /**
     * Get the view object
     *
     * @return null|Renderer
     */
    public function getView()
    {
        return $this->view;
    }



    /**
     * Invoke method
     *
     * @return   mixed
     */
    public function __invoke ($key=NULL)
    {
        if (NULL === $key) {
            return $this->storage;
        }

        return $this->get($key);
    }



    /**
     * Get variable
     *
     * @param    string   Name of variable to get
     * @return   void
     */
    public function get ($name)
    {
        if ($this->__isset($name)) {
            return $this->storage[$name];
        } else {
            return NULL;
        }
    }



    /**
     * Set variable
     *
     * @param    string   Name of variable to set
     * @param    mixed    Value to store
     * @return   void
     */
    public function set ($name, $value)
    {
        $this->storage[$name] = $value;
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
        return $this->get($name);
    }



    /**
     * Magic method: check if entity property exists
     *
     * @param    string   Property name to check
     * @return   bool
     */
    public function __isset ($name)
    {
        return isset($this->storage[$name]);
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
        $this->set($name, $value);
    }
}
