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
class Gateway
{



    /*
     * @var   array
     */
    protected $config;



    /*
     * @var   PHPMailer
     */
    protected $phpMailer;



    /*
     * Constructor
     *
     * @param    array    Configuration array for this mailer gateway
     *
     * @return   void
     */
    public function __construct ($config)
    {
        // Save config for later
        $this->config = $config;

        // Instantiate php mailer
        $mail = new \PHPMailer();

        // Type?
        switch ($config['type']) {
            case 'mail':
            case 'MAIL':
                $mail->isMail();
                break;

            case 'smtp':
            case 'SMTP':
                $mail->isSMTP();

                // Additional SMTP settings
                $mail->Host = $config['protocol'] .'://'. $config['host'];
                $mail->Port = $config['port'];

                if (!empty($config->username)) {
                    $mail->SMTPAuth = true;
                    $mail->Username = $config['username'];
                    $mail->Password = $config['password'];
                }

                $mail->SMTPDebug   = 0;   //Enable SMTP debugging: 0 = off (for production use), 1 = client messages, 2 = client and server messages
                $mail->Debugoutput = 'text';
                break;

            default:
                throw new Exception("Unknown mailer gateway type: ". $config['type']);
        }

        // Additional settings
        $mail->CharSet = 'UTF-8';
        $mail->setFrom($config['from']['email'], $config['from']['name']);

        // Store configured mailer now
        $this->phpMailer = $mail;
    }



    /*
     * Get configured PHPMailer instance
     *
     * @return   PHPMailer
     */
    public function getPhpMailer ()
    {
        // Remove all existing recipients
        $this->phpMailer->ClearAllRecipients();
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
        $mail = $this->phpMailer;

        // Ensure if all destination specifications are arrays
        if (!is_array($to )) { $to  = array($to)  ; }
        if (!is_array($cc )) { $cc  = array($cc)  ; }
        if (!is_array($bcc)) { $bcc = array($bcc) ; }

        // Add all recipients
        foreach ($to as $toAddr => $toName) {
            if (is_numeric($toAddr)) {
                $toAddr = $toName;
            }
            $mail->addAddress($toAddr, $toName);
        }

        foreach ($cc as $ccAddr => $ccName) {
            if (is_numeric($ccAddr)) {
                $ccAddr = $ccName;
            }
            $mail->addCC($ccAddr, $ccName);
        }

        foreach ($bcc as $bccAddr => $bccName) {
            if (is_numeric($bccAddr)) {
                $bccAddr = $bccName;
            }
            $mail->addBCC($bccAddr, $bccName);
        }


        // Content
        $mail->Subject = $subject;
        $mail->msgHTML($contentHTML);
        $mail->AltBody = strip_tags(nl2br($contentHTML));

        // Send the message, check for errors
        if (!$mail->send()) {
            throw new Exception("Mail Error: " . $mail->ErrorInfo . "\n");
        }
    }
}
