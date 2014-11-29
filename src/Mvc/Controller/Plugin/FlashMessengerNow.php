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
namespace Teon\Base\Mvc\Controller\Plugin;



/*
 * Class definition: FlashMessengerNow
 *
 * Same as ZF2's FlashMessenger, but it combines current and previous messages
 */
class     FlashMessengerNow
extends   \Zend\Mvc\Controller\Plugin\FlashMessenger
{



    /**
     * Pull messages from the session container, and merge them with current messages
     *
     * Iterates through the session container, removing messages into the local
     * scope.
     *
     * @return void
     */
    protected function getMessagesFromContainer()
    {
        $container = $this->getContainer();

        $namespaces = array();
        foreach ($container as $namespace => $messages) {
            if (isset($this->messages[$namespace])) {
                $this->messages[$namespace] = array_merge($this->messages[$namespace], $messages);
            } else {
                $this->messages[$namespace] = $messages;
            }
            $namespaces[] = $namespace;
        }

        foreach ($namespaces as $namespace) {
            unset($container->{$namespace});
        }
    }
}
