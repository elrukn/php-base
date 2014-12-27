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
 * Interface definition
 */
interface   ExternalEnvironmentInterface
{



    /*
     * Initialize external environment
     *
     * @return   void
     */
    public function initExternalEnvironment ();



    /*
     * Check if this request is from console
     *
     * @return   bool
     */
    public function isRequestFromConsole ();



    /*
     * Return HTTP Host of client's request
     *
     * @return   string
     */
    public function getHttpHost ();



    /*
     * Return remote IP address
     *
     * @return   string
     */
    public function getRemoteIpAddr ();



    /*
     * Do HTTP edirect
     *
     * @param    string   URI to redirect to
     * @param    int      Redirect code to use (optional, 302 is the default)
     * @return   void
     */
    public function redirect ($uri, $statusCode=302);



    /*
     * Do permanent redirect
     *
     * @param    string   URI to redirect to
     * @return   void
     */
    public function redirectPermanent ($uri);



    /*
     * Do temporary redirect
     *
     * @param    string   URI to redirect to
     * @return   void
     */
    public function redirectTemporary ($uri);



    /*
     * Set locale
     *
     * @param    string   Locale to set
     * @return   void
     */
    public function setLocale ($locale);
}
