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
namespace Teon\Base\Filter;



/*
 * Class definition
 */
class     NumberCommaToDot
extends   \Zend\Filter\AbstractFilter
{



    /**
     * Perform regexp replacement as filter
     *
     * @param  mixed $value
     * @return mixed
     * @throws Exception\RuntimeException
     */
    public function filter ($value)
    {
        return preg_replace('/,/', '.', $value);
    }
}
