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
 * This software is namespaced
 */
namespace Teon\Base;



/*
 * Required namespaces
 */
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;



/*
 * Class definition
 *
 * Zend Framework 2 module definition
 */
class        Module
implements   AutoloaderProviderInterface
{



    /*
     * Autoloader configuration
     */
    public function getAutoloaderConfig ()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src',
                ),
            ),
        );
    }



    /*
     * Module configuration
     */
    public function getConfig ()
    {
        return array();
    }



    /*
     * View helper registration
     */
    public function getViewHelperConfig()
    {
        return array(
           'invokables' => array(
              'LayoutDataContainer' => __NAMESPACE__ .'\View\Helper\LayoutDataContainer',
              'EuroFormat'          => __NAMESPACE__ .'\View\Helper\EuroFormat',
              'FormErrors'          => __NAMESPACE__ .'\View\Helper\FormErrors',
              'PageTitle'           => __NAMESPACE__ .'\View\Helper\PageTitle',
           ),
        );
   }}
