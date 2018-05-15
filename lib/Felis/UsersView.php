<?php

namespace Felis;


class UsersView extends View {

    public function __construct(Site $site) {
        $this->site = $site;

        $this->setTitle("Felis Investigations Users");
        $this->addLink("staff.php", "Staff");
        $this->addLink("post/logout.php", "Log out");
    }


    public function present() {
        $html = <<<HTML
<form class="table" method="post" action="post/users.php">
    <p>
    <input type="submit" name="add" id="add" value="Add">
    <input type="submit" name="edit" id="edit" value="Edit">
    <input type="submit" name="delete" id="delete" value="Delete">
    </p>

    <table>
        <tr>
            <th>&nbsp;</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
HTML;
        $users = new Users($this->site);
        $all = $users->getUsers();
        if($all !== null) {
            foreach ($all as $user) {
                $id = $user['id'];
                $name = $user['name'];
                $email = $user['email'];
                $role = $user['role'];

                $html .= <<<HTML
        <tr>
            <td><input type="radio" name="user" value="$id"></td>
            <td>$name</td>
            <td>$email</td>
            <td>$role</td>
        </tr>
HTML;
            }
        }


        $html .= "</table></form>";
        return $html;
    }

    private $site;
}