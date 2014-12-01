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

use \Zend\View\Helper as ZVH;



/*
 * Class definition
 */
class     FormErrors
extends   ZVH\AbstractHelper
{



    /**
     * Returns rendered form error messages
     *
     * @param    \Zend\Form\FormInterface
     * @throws   Exception\RuntimeException
     * @return   string
     */
    public function __invoke($Form)
    {
        $content = '';
        $errMsgs = $Form->getMessages();

        if (0 == count($errMsgs)) {
            return $content;
        }

        $content .= "\n\n";
        $content .= "<div class='alert alert-danger' role='alert'>\n";
        $content .= "    <b>Napaka!</b><br />\n";
        $content .= "    <ul>\n";

        foreach ($errMsgs as $elName => $elMsgs) {
            $elLabel = $Form->get($elName)->getLabel();
            $elLabel = (!empty($elLabel) ? $elLabel : $Form->get($elName)->getOption('label'));
            $elLabel = (!empty($elLabel) ? "$elLabel: " : "");
            foreach ($elMsgs as $elMsg) {
                $content .= "        <li>$elLabel $elMsg</li>\n";
            }
        }
        $content .= "    </ul>\n";
        $content .= "</div>\n";
        $content .= "\n\n";

        return $content;
    }
}
