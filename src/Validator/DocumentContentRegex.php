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
namespace Teon\Base\Validator;



/*
 * Class definition
 */
class     DocumentContentRegex
extends   \Zend\Validator\Regex
{



    /**
     * Is value valid?
     *
     * @param    ...   Value to verify
     * @return   bool
     */
    public function isValid ($value)
    {
        if (!($value instanceof \Teon\Base\Text\Extractor\ExtractorInterface)) {
            $this->error(self::INVALID);
            return false;
        }
        $TextExtractor = $value;

        // Store value - all ZF2 validators do it
        $this->setValue($TextExtractor);

        \Zend\Stdlib\ErrorHandler::start();
        $status = preg_match($this->pattern, $TextExtractor->getText());
        \Zend\Stdlib\ErrorHandler::stop();

        if (false === $status) {
            $this->error(self::ERROROUS);
            return false;
        }

        if (!$status) {
            $this->error(self::NOT_MATCH);
            return false;
        }

        return true;
    }
}
