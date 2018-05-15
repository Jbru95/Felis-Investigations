<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 3/25/2018
 * Time: 9:02 PM
 */

namespace Felis;


class UserController{

    private $redirect;	///< Page we will redirect the user to.

    public function getRedirect() {
        return $this->redirect;
    }

    public function __construct(Site $site, User $user, array $post) {
        $root = $site->getRoot();
        $this->redirect = "$root/users.php";

        if(isset($post['Cancel'])){
            $this->redirect = "$root/users.php";
            return;
        }

        // Determine if this is new user or editing an
        // existing user. We determine that by looking for
        // a hidden form element named "id". If there, it
        // gives the ID for the user we are editing. Otherwise,
        // we have no user, so I'll use an ID of 0 to indicate
        // that we are adding a new user.

        $id = strip_tags($post['id']);

        // Get all of the stuff from the form
        $email = strip_tags($post['email']);
        $name = strip_tags($post['name']);
        $phone = strip_tags($post['phone']);
        $address = strip_tags($post['address']);
        $notes = strip_tags($post['notes']);
        switch($post['role']) {
            case "admin":
                $role = User::ADMIN;
                break;

            case "staff":
                $role = User::STAFF;
                break;

            default:
                $role = User::CLIENT;
                break;
        }

        $row = array('id' => $id,
            'email' => $email,
            'name' => $name,
            'phone' => $phone,
            'address' => $address,
            'notes' => $notes,
            'password' => null,
            'joined' => null,
            'role' => $role
        );
        $editUser = new User($row);//called edituser because shares name w/ param

        $users = new Users($site);

        if($id != 0){
            $users->update($editUser);
        }

        else if($id == 0) {
            // This is a new user
            $mailer = new Email();
            $users->add($editUser, $mailer);
        }
    }



}