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
 * Namespace defition
 */
namespace Teon\Base\Mvc\Controller;



/*
 * Class definition
 */
class     AbstractActionController
extends   \Zend\Mvc\Controller\AbstractActionController
{



    /*
     * Subcomponent storage variables, and their aliases
     */
    protected $appCore;
    protected $_appCore;
    protected $core;
    protected $_core;

    protected $appView;
    protected $_appView;
    protected $view;
    protected $_view;

    protected $flashMessenger;
    protected $fm;



    /*
     * Constructor
     */
    public function __construct ()
    {
        // $this->_initAppCore();   // Application-specific
        $this->_initView();
        $this->_initFlashMessenger();
    }



    /*
     * INIT: Initialize View
     *
     * @return   null
     */
    protected function _initView ()
    {
        // Create default view model, to be used in all templates and layouts
        $this->appView  = new \Zend\View\Model\ViewModel();

        // Convenience access variables
        $this->_appView = $this->appView;
        $this->view     = $this->appView;
        $this->_view    = $this->appView;
    }



    /*
     * INIT: Initialize FlashMessenger
     *
     * @return   null
     */
    protected function _initFlashMessenger ()
    {
        // Init and assign flash messenger instance, to be used in layout and/or templates
        //$this->flashMessenger       = $this->plugin('flashMessenger');   // Do not use $this->flashMessenger() as this method is defined below

        // Original FM does not display current messages (added on this request).
        // We use this enhanced version instead.
        $this->flashMessenger       = new \Teon\Base\Mvc\Controller\Plugin\FlashMessengerNow();

        // Default messages are info messages
        $this->flashMessenger->setNamespace('info');

        // Convenience access
        $this->fm                   = $this->flashMessenger;
        $this->view->flashMessenger = $this->flashMessenger;
        $this->view->fm             = $this->flashMessenger;
    }



    /*
     * WORKAROUND: Prevent creation of new flash messenger instance
     *
     * If not defined, call to this function in action method of instantiated controller
     * returns new instance of flashMessenger, despite the fact that calling the same function
     * in parent class' controller already instantiates one flash messenger instance.
     *
     * Funny thing - calling the same function in instantiated controller's constructor yields
     * correct object. Only calling it in action returns new instance.
     *
     * @return   \Zend\Mvc\Controller\Plugin\FlashMessenger
     */
    protected function flashMessenger ()
    {
        return $this->flashMessenger;
    }



    /*
     * HELPER: Forward to action in the same controller
     *
     * @param    string   Action to forward to
     * @param    array    Parameters to pass (optional)
     * @return   \Zend\Mvc\Controller\Plugin\FlashMessenger
     */
    protected function forwardAction ($action, $params=array())
    {
        // Get own controller name
        if (!preg_match("/([_a-zA-Z0-9]+)\$/", get_class($this), $m)) {
            throw new \TeamDoe\Controller\Exception("Unable to extract short controller name: ". get_class($this));
        }
        $controllerShortName = strtolower(preg_replace('/Controller$/', '', $m[1]));

        // Combine parameters - if action is explicitly specified in params it is overriden
        $params2pass = array_merge(
            $params,
            array('action' => $action)
        );

        return $this->forward()->dispatch($controllerShortName, $params2pass);
    }
}
