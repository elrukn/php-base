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
class        Docx
extends      AbstractExtractor
implements   ExtractorInterface
{



    /*
     * Supported extensions
     */
    protected $supportedExtensions = array(
        'docx' => true,
//        'dotx' => true,
    );



    /*
     * Supported media types
     */
    protected $supportedMediaTypes = array(
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => true,
//        'application/vnd.openxmlformats-officedocument.wordprocessingml.template' => true,
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
        if (!$zip || is_numeric($zip)) {
            throw new Exception("Failed to zip-open file: ". $this->getFilePath());
        }

        // Read/parse
        $content = '';
        while ($zip_entry = zip_read($zip)) {
            if (zip_entry_open($zip, $zip_entry) == FALSE) continue;
            if (zip_entry_name($zip_entry) != "word/document.xml") continue;
            $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
            zip_entry_close($zip_entry);
        }
        zip_close($zip);

        // Reparse entries
        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content = str_replace('</w:r></w:p>', "\r\n", $content);
        $striped_content = strip_tags($content);

        return $striped_content;
    }
}
