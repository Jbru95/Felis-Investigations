<?php

namespace Felis;


class UsersController {

    public function __construct(Site $site, User $user, array $post) {
        $root = $site->getRoot();
        $this->redirect = "$root/users.php";

        if(isset($post['add'])){//take to empty user.php form
            $this->redirect = "$root/user.php";
        }
        else if(isset($post['edit']) and isset($post['user'])){//takes to user.php with user info filled in
            $this->redirect = "$root/user.php?id=". $post['user'];
        }
        else if(isset($post['delete']) and isset($post['user'])){
            $users = new Users($site);
            $users->delete($post['user']);
            $this->redirect = "$root/users.php";
        }
    }

    public function getRedirect() {
        return $this->redirect;
    }

    private $redirect;	///< Page we will redirect the user to.
}