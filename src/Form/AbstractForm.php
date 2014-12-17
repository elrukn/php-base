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
abstract class   AbstractForm
extends          \Zend\Form\Form
implements       \Zend\InputFilter\InputFilterProviderInterface
{



    /*
     * @var   \Zend\InputFilter\InputFilter
     */
    protected $inputFilterSpecification;



    /*
     * @var   \Zend\InputFilter\InputFilter
     */
    protected $commonElementConfig = array(
        'attributes' => array(
            'required'   => true,
            'class'      => 'form-control',
        ),
    );



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
        $this->addElement_csrf();

        // Add custom elements and validators
        $this->addElementsAndValidators();

        // Add input filters
        $this->setInputFilter($this->getInputFilterSpecification());
    }



    /*
     * Populate form with elements and validators
     *
     * This method must be implemented.
     *
     * @return   void
     */
    abstract public function addElementsAndValidators ();



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
    public function getInputFilterSpecification ()
    {
        if (NULL === $this->inputFilterSpecification) {
            throw new Exception("Input filter specification is undefined");
        }
        return $this->inputFilterSpecification;
    }



    /*
     * Add element - CSRF
     *
     * @return   string
     */
    protected function addElement_csrf ()
    {
        $el = new ZFE\Csrf('csrfSecurity');
        $el->setOptions(array(
            'csrf_options' => array(
                'timeout' => 900,
             ),
        ));

        // Do not add label to hidden elements, it renders if form is rendered with ZfcTwBootstrap
        //$el->setOption('label', 'CSRF Security');
        $this->add($el);
    }



    /*
     * Add element - TEXT
     *
     * @param    string   Name of element
     * @param    string   Element label
     * @param    array    Custom element configuration overrides (optional)
     * @return   void
     */
    protected function addElement_text ($name, $label, $customElementConfig=array())
    {
        $defaultElementConfig = array(
            'name'       => $name,
            'attributes' => array(
                'id'         => $name,
            ),
            'options'    => array(
                'label'      => $label,
            ),
        );
        $elementConfig = array_replace_recursive(
            $defaultElementConfig,
            $customElementConfig
        );

        $this->addElement_text_configArray($elementConfig);
    }



    /*
     * Add element - TEXT - with config array
     *
     * @param    array   Custom element configuration overrides
     * @return   void
     */
    protected function addElement_text_configArray ($customElementConfig)
    {
        $defaultElementConfig = array(
            'name'       => 'text',
            'type'       => 'text',
            'attributes' => array(
                'id'         => 'text',
            ),
            'options'    => array(
                'label'      => 'Text input',
            ),
        );

        $this->addElement_generic_mergeConfig(
            $this->commonElementConfig,
            $defaultElementConfig,
            $customElementConfig
        );
    }



    /*
     * Add element - TEXTAREA
     *
     * @param    string   Name of element
     * @param    string   Element label
     * @param    array    Custom element configuration overrides (optional)
     * @return   void
     */
    protected function addElement_textarea ($name, $label, $customElementConfig=array())
    {
        $defaultElementConfig = array(
            'name'       => $name,
            'attributes' => array(
                'id'         => $name,
            ),
            'options'    => array(
                'label'      => $label,
            ),
        );
        $elementConfig = array_replace_recursive(
            $defaultElementConfig,
            $customElementConfig
        );

        $this->addElement_textarea_configArray($elementConfig);
    }



    /*
     * Add element - TEXTAREA - with config array
     *
     * @param    array   Custom element configuration overrides
     * @return   void
     */
    protected function addElement_textarea_configArray ($customElementConfig)
    {
        $defaultElementConfig = array(
            'name'       => 'textarea',
            'type'       => 'textarea',
            'attributes' => array(
                'id'         => 'textarea',
            ),
            'options'    => array(
                'label'      => 'Text area input',
            ),
        );

        $this->addElement_generic_mergeConfig(
            $this->commonElementConfig,
            $defaultElementConfig,
            $customElementConfig
        );
    }



    /*
     * Add element - SUBMIT
     *
     * @param    string   Submit button caption/value
     * @param    string   CSS class(es)
     * @return   string
     */
    protected function addElement_submit ($value, $customElementConfig=array())
    {
        $defaultElementConfig = array(
            'attributes' => array(
                'value'      => $value,
            ),
        );
        $elementConfig = array_replace_recursive(
            $defaultElementConfig,
            $customElementConfig
        );

        $this->addElement_submit_configArray($elementConfig);
    }



    /*
     * Add element - SUBMIT - with config array
     *
     * @param    array   Custom element configuration overrides
     * @return   void
     */
    protected function addElement_submit_configArray ($customElementConfig)
    {
        $defaultElementConfig = array(
            'name'       => 'submit',
            'attributes' => array(
                'id'         => 'submit',
                'type'       => 'submit',
                'value'      => 'Submit',
                'class'      => 'btn btn-danger',
            ),
        );

        $this->addElement_generic_mergeConfig(
            $this->commonElementConfig,
            $defaultElementConfig,
            $customElementConfig
        );
    }



    /*
     * Add generic element by merging multiple configs - variadic function
     *
     * @param    array   Multiple arrays of element configuration, to be merged
     * @param    array   ...
     * @return   void
     */
    protected function addElement_generic_mergeConfig ()
    {
        $elementConfigFinal = call_user_func_array('array_replace_recursive', func_get_args());
        $this->add($elementConfigFinal);
    }
}
