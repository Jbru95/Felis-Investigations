<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 3/19/2018
 * Time: 5:44 PM
 */

namespace Felis;


class LoginController{

    private $redirect;

    public function getRedirect() {
        return $this->redirect;
    }


    /**
     * LoginController constructor.
     * @param Site $site The Site object
     * @param array $session $_SESSION
     * @param array $post $_POST
     */
    public function __construct(Site $site, array &$session, array $post){

        //Create a Users object to access the table
        $users = new Users($site);

        $email = strip_tags($post['email']);
        $password = strip_tags($post['password']);
        $user = $users->login($email, $password);
        $session[User::SESSION_NAME] = $user;

        $root = $site->getRoot();
        if($user === null){
            $this->redirect = "$root/login.php?e";
        }
        else{
            if($user->isStaff()){
                $this->redirect = "$root/staff.php";
            }
            else{
                $this->redirect = "$root/client.php";
            }
        }

    }
}