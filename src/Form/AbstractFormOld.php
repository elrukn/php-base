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
namespace Teon\Base\Form;

use       \Zend\Form\Element as ZFE;


/*
 * Class definition
 */
abstract class   AbstractFormOld
extends          \Zend\Form\Form
implements       \Zend\InputFilter\InputFilterProviderInterface
{



    /*
     * @var   \Zend\InputFilter\InputFilter
     */
    protected $inputFilterSpecification;



    /*
     * Constructor
     *
     * Create form object
     *
     * @return   null
     */
    public function __construct ($name=NULL, $options=array())
    {
        if (NULL === $name) {
            $name = $this->_getFormName();
        }
        parent::__construct($name, $options);

        // CSRF protection on all forms
        $el = new ZFE\Csrf('csrfSecurity');

        // Do not add label to hidden elements, it renders if form is rendered with ZfcTwBootstrap
        //$el->setOption('label', 'CSRF Security');
        $this->add($el);

        // Add input filters
        $this->setInputFilter($this->getInputFilterSpecification());
    }



    /*
     * Get form name
     *
     * @return   string
     */
    protected function _getFormName ()
    {
        return str_replace("\\", "_", get_called_class());
    }



    /*
     * Return array of input filters
     *
     * This method must not be named "getInputFilters()", as that name is already taken by \Zend\Form\Form
     *
     * @return   array   Array of input filters
     */
    abstract public function getInputFilterSpecification ();
}
