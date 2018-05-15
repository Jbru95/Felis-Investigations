<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 3/26/2018
 * Time: 11:12 AM
 */

namespace Felis;


class PasswordValidateView extends View{

    private $validator;
    private $error_msg;
    private $error = false;

    public function __construct($site, $get){
        $this->setTitle("Felis Password Entry");
        $this->validator = strip_tags($get['v']);

        if(isset($get['e'])){
            $this->error = true;
            if( $get['e'] == 1){
                $this->error_msg = "No valid validator for this user!";
            }else if( $get['e'] == 2){
                $this->error_msg = "Email address is not for a valid user!";
            }else if( $get['e'] == 3){
                $this->error_msg = "Email address does not match validator!";
            }else if( $get['e'] == 4){
                $this->error_msg = "Passwords do not match!";
            }else if( $get['e'] == 5){
                $this->error_msg = "Password is too short, must be at least 8 characters!";
            }
        }
    }


    public function present(){

        $html = "";

        if($this->error == true){
            $html .= "<p>$this->error_msg</p>";
        }

        $html .= <<<HTML
<form method="post" action="post\password-validate.php">
	<fieldset>
		<legend>Change Password</legend>
		<p>
			<label for="email">Email:</label><br>
			<input type="text" id="email" name="email" placeholder="Email">
		</p>
		<p>
			<label for="password">Password:</label><br>
			<input type="text" id="password" name="password" placeholder="password">
		</p>
		<p>
			<label for="password2">Password(again):</label><br>
			<input type="text" id="password2" name="password2" placeholder="password">
		</p>
		<p>
			<input type="submit" name="OK" value="OK">&nbsp;<input type="submit" name="Cancel" value="Cancel">
		</p>
		<input type="hidden" name="validator" value="$this->validator">
	</fieldset>
</form>
HTML;

        return $html;

    }
}