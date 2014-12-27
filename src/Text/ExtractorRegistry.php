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
namespace Teon\Base\Text;



/*
 * Class definition
 */
class   ExtractorRegistry
{



    /*
     * Supported extractors
     */
    protected $extractors = array(
        'Doc',
        'Docx',
        'Odt',
        'Pdf',
        'Txt',
    );



    /*
     * Find extractor by extension
     *
     * @param    string   Extension to look for
     * @return   Extractor\ExtractorInterface|NULL
     */
    public function findExtractorByExtension ($extension)
    {
        // Check all extractors
        foreach ($this->extractors as $extractorName) {
            $className = __NAMESPACE__ ."\\Extractor\\$extractorName";
            $Extractor = new $className();
            if ($Extractor->isExtensionSupported($extension)) {
                return $Extractor;
            }
        }

        // Extractor was not found
        return NULL;
    }



    /*
     * Get extractor by extension
     *
     * @param    string   Extension to look for
     * @return   Extractor\ExtractorInterface
     */
    public function getExtractorByExtension ($extension)
    {
        $Extractor = $this->findExtractorByExtension($extension);

        if (NULL === $Extractor) {
            throw new Exception("Text extractor for extension not found: ". $extension);
        }

        return $Extractor;
    }



    /*
     * Get extractor by media type
     *
     * @param    string   Media type to look for
     * @return   Extractor\ExtractorInterface|NULL
     */
    public function findExtractorByMediaType ($mediaType)
    {
        // Check all extractors
        foreach ($this->extractors as $extractorName) {
            $className = __NAMESPACE__ ."\\Extractor\\$extractorName";
            $Extractor = new $className();
            if ($Extractor->isMediaTypeSupported($mediaType)) {
                return $Extractor;
            }
        }

        // Extractor was not found
        return NULL;
    }



    /*
     * Get extractor by media type
     *
     * @param    string   Media type to look for
     * @return   Extractor\ExtractorInterface
     */
    public function getExtractorByMediaType ($mediaType)
    {
        $Extractor = $this->findExtractorByMediaType($mediaType);

        if (NULL === $Extractor) {
            throw new Exception("Text extractor for media type not found: ". $mediaType);
        }

        return $Extractor;
    }
}
