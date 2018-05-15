<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 3/26/2018
 * Time: 11:30 AM
 */

namespace Felis;


class PasswordValidateController
{

    private $redirect;
    private static $INVALID_VALIDATOR = '1';
    private static $EMAIL_ADDRESS_INVALID = '2';
    private static $EMAIL_DOESNT_MATCH = '3';
    private static $PASSWORDS_DONT_MATCH = '4';
    private static $PASSWORD_TOO_SHORT = '5';

    public function getRedirect()
    {
        return $this->redirect;
    }

    public function __construct(Site $site, array $post)
    {
        $root = $site->getRoot();
        $this->redirect = "$root/password-validate.php?v=" . $post['validator'];

        if(isset($post['Cancel'])){
            $this->redirect = "$root/";
            return;
        }

        //$this->redirect = "$root/";

        // 1. Ensure the validator is correct! Use it to get the user ID.
        $validators = new Validators($site);
        $validator = strip_tags($post['validator']);
        $userid = $validators->get($validator);
        if ($userid === null) {
            $this->redirect = "$root/password-validate.php?v=$validator&e=".self::$INVALID_VALIDATOR;
            return;
        }

        // 2. Ensure the email matches the user.
        $users = new Users($site);
        $editUser = $users->get($userid);
        if ($editUser === null) {
            // User does not exist!
            $this->redirect = "$root/password-validate.php?v=$validator&e=".self::$EMAIL_ADDRESS_INVALID;
            return;
        }
        $email = trim(strip_tags($post['email']));
        if ($email !== $editUser->getEmail()) {
            // Email entered is invalid
            $this->redirect = "$root/password-validate.php?v=$validator&e=".self::$EMAIL_DOESNT_MATCH;
            return;
        }

        // 3. Ensure the passwords match each other
        $password1 = trim(strip_tags($post['password']));
        $password2 = trim(strip_tags($post['password2']));
        if ($password1 !== $password2) {
            // Passwords do not match
            $this->redirect = "$root/password-validate.php?v=$validator&e=".self::$PASSWORDS_DONT_MATCH;
            return;
        }

        if (strlen($password1) < 8) {
            // Password too short
            $this->redirect = "$root/password-validate.php?v=$validator&e=".self::$PASSWORD_TOO_SHORT;
            return;
        }

        // 4. Create a salted password and save it for the user.
        $users->setPassword($userid, $password1);

        // 5. Destroy the validator record so it can't be used again!
        $validators->remove($userid);

        $this->redirect = "$root/";
    }
}
