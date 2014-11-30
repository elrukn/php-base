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
namespace Teon\Base\Mailer;



/*
 * Class definition
 */
class Mailer
{



    /*
     * @var   array
     */
    protected $config;



    /*
     * @var   array
     */
    protected $gateways = array();



    /*
     * Constructor
     *
     * @param    array    Configuration array for this mailer subsystem (with at least one gateway)
     *
     * @return   void
     */
    public function __construct ($config)
    {
        // Save config for later
        $this->config = $config;

        // Initiate all gateways
        foreach ($config['gateways'] as $gwConfig) {
            $this->gateways[] = new Gateway($gwConfig);
        }
    }



    /**
     * Send HTML mail
     *
     * @param    string   Subject
     * @param    string   Message in HTML format
     * @param    array    To: recipients
     * @param    array    Cc: recipients
     * @param    array    Bcc: recipients
     * @return   void
     */
    public function sendHtml ($subject, $contentHTML, $to, $cc=array(), $bcc=array())
    {
        $firstErrorMsg = '';
        $lastErrorMsg  = '';

        // Try gateways in order
        foreach ($this->gateways as $gw) {
            try {
                $gw->sendHtml($subject, $contentHTML, $to, $cc, $bcc);

                // If previous function did not throw an exception, mail deportation was successfull
                return;

            } catch (\Exception $e) {
                // Sending failed, try, next gw, store error message
                if ('' === $firstErrorMsg) {
                    $firstErrorMsg = $e->getMessage();
                }
                $lastErrorMsg = $e->getMessage();
            }
        }

        // If we reach this point, we know all GWs failed
        throw new Exception("Sending email failed through all gateways (". count($this->gateways) ." configured).\n\nFirst error message: $firstErrorMsg\nLast error message: $lastErrorMsg");
    }
}
