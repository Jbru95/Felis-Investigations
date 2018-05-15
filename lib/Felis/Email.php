<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 3/26/2018
 * Time: 12:21 AM
 */

namespace Felis;

/**
 * Email adapter class
 */
class Email {
    public function mail($to, $subject, $message, $headers) {
        mail($to, $subject, $message, $headers);
    }
}