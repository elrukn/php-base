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
namespace Teon\Base\Text\Extractor;



/*
 * Class definition
 */
class        Doc
extends      AbstractExtractor
implements   ExtractorInterface
{



    /*
     * Supported extensions
     */
    protected $supportedExtensions = array(
        'doc' => true,
    );



    /*
     * Supported media types
     */
    protected $supportedMediaTypes = array(
        'application/msword' => true,
    );



    /*
     * Parse the file
     *
     * Implementation adapted from this source:
     * http://stackoverflow.com/questions/5540886/extract-text-from-doc-and-docx
     *
     * @param    string   Path to file to parse (optional)
     * @return   void
     * @throws   Exception   If file is not readable
     */
    public function getText ($filePath=NULL)
    {
        // If file path is give, try to use that, otherwise just recheck file path
        if (NULL !== $filePath) {
            $this->setFilePath($filePath);
        } else {
            $this->setFilePath($this->getFilePath());
        }

        // Open it first
        $zip = zip_open($this->getFilePath());

        $fileHandle = fopen($this->getFilePath(), "r");
        $line  = fread($fileHandle, filesize($this->getFilePath()));
        $lines = explode(chr(0x0D), $line);

        $outtext = '';
        foreach($lines as $thisline) {
            $pos = strpos($thisline, chr(0x00));
            if (($pos !== FALSE)||(strlen($thisline)==0))
            {
            } else {
                $outtext .= $thisline." ";
            }
        }
        $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$outtext);
        return $outtext;
    }
}
