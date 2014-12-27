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
class        Pdf
extends      AbstractExtractor
implements   ExtractorInterface
{



    /*
     * Supported extensions
     */
    protected $supportedExtensions = array(
        'pdf' => true,
    );



    /*
     * Supported media types
     */
    protected $supportedMediaTypes = array(
        'application/pdf'   => true,
        'application/x-pdf' => true,
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

        // Parse pdf file and return raw text
        $PdfParser = new \Smalot\PdfParser\Parser();
        $PdfDoc    = $PdfParser->parseFile($this->getFilePath());

        return $PdfDoc->getText();
    }
}
