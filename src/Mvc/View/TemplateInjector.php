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
namespace Teon\Base\Mvc\View;



/*
 * Class definition
 */
class     TemplateInjector
{



    /*
     * Return template path to render
     */
    public function __invoke(\Zend\Mvc\MvcEvent $event)
    {

        // Get current viewmodel that we are concerned about
        $ViewModel = $event->getResult();
        if (!$ViewModel instanceof \Zend\View\Model\ViewModel) {
            return;
        }


$controller = \Teon\Base\Stdlib\ClassUtils::getPublicControllerName(get_class($event->getTarget()));
echo $controller;
$action = $event->getRouteMatch()->getParam('action');
echo $action;
var_dump( get_class_methods($ViewModel));
var_dump($ViewModel->getTemplate()); exit;


        // We only try to resolve templates that are explicitly set, but short-named
        if (empty($ViewModel->getTemplate())) {
            return;
        }

echo get_class($ViewModel); exit;

        // Get controller that handled the requested template
        $controller = $event->getTarget();
        if (!is_object($controller)) {
            return;
        }

        $namespace = explode('\\', ltrim(get_class($controller), '\\'));
 
        $controllerClass = array_pop($namespace);
        array_pop($namespace); //remove a folder name holding controllers
        array_shift($namespace); //remove a company name
 
        $moduleName = implode('/', $namespace);
 
        $controller = substr($controllerClass, 0, strlen($controllerClass) - strlen('Controller'));
        $model->setTemplate(strtolower($moduleName.'/'.$controller.'/'.$action));
    }
}
