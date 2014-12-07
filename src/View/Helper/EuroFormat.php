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
class     EuroFormat
extends   ZVH\AbstractHelper
{



    /**
     * Returns formatted Euro currency number
     *
     * @param    string|int
     * @return   string
     */
    public function __invoke ($number)
    {
        return number_format($number, 2, ',', '.') .' €';
    }
}
