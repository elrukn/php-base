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
namespace Teon\Base\Core\ExternalEnvironment;



/*
 * Class definition
 */
class        ZendMvcApplication
implements   ExternalEnvironmentInterface
{



     /*
     * Import trait: singleton factory
     */
    use \Teon\Base\Singleton\SingletonFactoryTrait;



    /*
     * Store reference external application
     *
     * @var   \Zend\Mvc\Application
     */
    protected $Application;




    /*
     * Initializer to be called (explicitly, currently not possible from constructor)
     *
     * @return   void
     */
    public function _init ($Application)
    {
        $this->Application = $Application;
        $this->initExternalEnvironment();
    }



    /*
     * Initialize external environment
     *
     * @return   void
     */
    public function initExternalEnvironment ($charset='UTF-8', $timezone='UTC', $locale='en_US')
    {
        // Charset, timezone and locale - set sane defaults
        ini_set('default_charset',              $charset);
        ini_set('mbstring.language',            'Neutral');
        ini_set('mbstring.internal_encoding',   $charset);
        iconv_set_encoding('internal_encoding', $charset);
        iconv_set_encoding('input_encoding',    $charset);
        iconv_set_encoding('output_encoding',   $charset);
        date_default_timezone_set($timezone);
        setlocale(LC_ALL, $locale);
    }



    /*
     * Check if this request is from console
     *
     * @return   bool
     */
    public function isRequestFromConsole ()
    {
        if ($this->Application->getRequest() instanceof \Zend\Console\Request) {
            return true;
        } else {
            return false;
        }
    }



    /*
     * Return HTTP Host of client's request
     *
     * @return   string
     */
    public function getHttpHost ()
    {
        return $this->Application->getRequest()->getUri()->getHost();
    }



    /*
     * Return remote IP address
     *
     * @return   string
     */
    public function getRemoteIpAddr ()
    {
        return $this->Application->getRequest()->getServer()->get('REMOTE_ADDR');
    }



    /*
     * Do HTTP edirect
     *
     * @param    string   URI to redirect to
     * @param    int      Redirect code to use (optional, 302 is the default)
     * @return   void
     */
    public function redirect ($uri, $statusCode=302)
    {
        header("HTTP/1.1 $statusCode Moved");
        header("Location: $uri");
        exit;
    }



    /*
     * Do permanent redirect
     *
     * @param    string   URI to redirect to
     * @return   void
     */
    public function redirectPermanent ($uri)
    {
        $this->redirect($uri, 301);
    }



    /*
     * Do temporary redirect
     *
     * @param    string   URI to redirect to
     * @return   void
     */
    public function redirectTemporary ($uri)
    {
        $this->redirect($uri, 302);
    }



    /*
     * Set locale
     *
     * @param    string   Locale to set
     * @return   void
     */
    public function setLocale ($locale)
    {
        setlocale(LC_ALL, $locale);
    }
}
