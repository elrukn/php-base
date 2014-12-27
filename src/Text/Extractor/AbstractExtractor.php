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
abstract class   AbstractExtractor
{



    /*
     * Supported extensions, without leading dots
     *
     * @var   array
     */
    protected $supportedExtensions = array(
//        'txt' => true,
    );



    /*
     * Supported media types
     *
     * @var   array
     */
    protected $supportedMediaTypes = array(
//        'text/plain' => true,
    );



    /*
     * File to parse
     *
     * @var   string
     */
    protected $filePath = NULL;



    /*
     * Contructor
     *
     * @param    string   Path to file to parse
     * @return   void
     */
    public function __construct ($filePath=NULL)
    {
        // If file path is already given at contruct time, use it
        if (NULL !== $filePath) {
            $this->setFilePath($filePath);
        }
    }



    /*
     * Is extension supported
     *
     * @param    string   Extension to check, no leading dot
     * @return   bool
     */
    public function isExtensionSupported ($extension)
    {
        return isset($this->supportedExtensions[strtolower($extension)]);
    }



    /*
     * Is media type supported
     *
     * @param    string   Media type to check
     * @return   bool
     */
    public function isMediaTypeSupported ($mediaType)
    {
        return isset($this->supportedMediaTypes[strtolower($mediaType)]);
    }



    /*
     * Get supported extensions
     *
     * @return   array    ('supported-extension' => true, ...)
     */
    public function getSupportedExtensions ()
    {
        return $this->supportedExtensions;
    }



    /*
     * Get supported media types
     *
     * @return   array    ('media/type' => true, ...)
     */
    public function getSupportedMediaTypes ()
    {
        return $this->supportedMediaTypes;
    }



    /*
     * Set file path
     *
     * @param    string   Path to file to parse
     * @return   void
     * @throws   Exception   If file is not readable
     */
    public function setFilePath ($filePath)
    {
        // Check existence
        if (!file_exists($filePath)) {
            throw new Exception("File does not exist: $filePath");
        }

        // Check if actualy a file
        if (!is_file(realpath($filePath))) {
            throw new Exception("Not an actual file: $filePath");
        }

        // Check accessibility
        if (!is_readable($filePath)) {
            throw new Exception("File is not readable: $filePath");
        }

        // Store file path then
        $this->filePath = $filePath;

        // Fluent interface
        return $this;
    }



    /*
     * Get file path
     *
     * @return   string   Path to file to parse
     */
    public function getFilePath ()
    {
        return $this->filePath;
    }



    /*
     * Read file
     *
     * @return   string      Raw file contents
     * @throws   Exception
     */
    protected function readFile ()
    {
        // Do the check again - there might be some time between setting the path
        // and reading the file
        $this->setFilePath($this->getFilePath());

        // Read the actual file
        return file_get_contents($this->getFilePath());
    }
}
