<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 3/25/2018
 * Time: 9:02 PM
 */

namespace Felis;


class UserView extends View{

    private $userId;

    public function __construct(Site $site, $get) {
        $this->site = $site;

        if (isset($get['id'])){
            $this->userId = $get['id'];
        }
        else{
            $this->userId = 0;
        }

        $this->setTitle("Felis User");
        $this->addLink("users.php", "Users");
        $this->addLink("staff.php", "Staff");
        $this->addLink("post/logout.php", "Log out");
    }


    public function present() {

        if($this->userId == 0) {
            $html = <<<HTML
<form method="post" action="post\user.php">
	<fieldset>
		<legend>User</legend>
		<p>
			<label for="email">Email</label><br>
			<input type="email" id="email" name="email" placeholder="Email">
			<input type="hidden" name="id" value="$this->userId"
		</p>
		<p>
			<label for="name">Name</label><br>
			<input type="text" id="name" name="name" placeholder="Name">
		</p>
		<p>
			<label for="phone">Phone</label><br>
			<input type="text" id="phone" name="phone" placeholder="Phone">
		</p>
		<p>
			<label for="address">Address</label><br>
			<textarea id="address" name="address" placeholder="Address"></textarea>
		</p>
		<p>
			<label for="notes">Notes</label><br>
			<textarea id="notes" name="notes" placeholder="Notes"></textarea>
		</p>
		<p>
			<label for="role">Role: </label>
			<select id="role" name="role">
                <option value="admin" selected>Admin</option>
                <option value="staff">Staff</option>
                <option value="client">Client</option>
			</select>
		</p>
		<p>
			<input type="submit" name="OK" value="OK"> <input type="submit" name="Cancel" value="Cancel">
		</p>

	</fieldset>
</form>

	<p>
		Admin users have complete management of the system. Staff users are able to view and make
		reports for any client, but cannot edit the users. Clients can only view the cases
		they have contracted for.
	</p>
HTML;
            return $html;
        }

        else {
            $users = new Users($this->site);
            $user = $users->get($this->userId);
            $email = $user->getEmail();
            $name = $user->getName();
            $phone = $user->getPhone();
            $address = $user->getAddress();
            $notes = $user->getNotes();
            $role = $user->getRole();

            $html = <<<HTML
<form method="post" action="post\user.php">
	<fieldset>
		<legend>User</legend>
		<p>
			<label for="email">Email</label><br>
			<input type="email" id="email" name="email" placeholder="Email" value="$email">
			<input type="hidden" name="id" value="$this->userId"
		</p>
		<p>
			<label for="name">Name</label><br>
			<input type="text" id="name" name="name" placeholder="Name" value="$name">
		</p>
		<p>
			<label for="phone">Phone</label><br>
			<input type="text" id="phone" name="phone" placeholder="Phone" value="$phone">
		</p>
		<p>
			<label for="address">Address</label><br>
			<textarea id="address" name="address" placeholder="Address">$address</textarea>
		</p>
		<p>
			<label for="notes">Notes</label><br>
			<textarea id="notes" name="notes" placeholder="Notes">$notes</textarea>
		</p>
		<p>
			<label for="role">Role: </label>
			<select id="role" name="role">
HTML;
            if ($role == 'A') {
                $html .= '<option value="admin" selected>Admin</option><option value="staff">Staff</option><option value="client">Client</option>';
            } else if ($role == "C") {
                $html .= '<option value="admin">Admin</option><option value="staff">Staff</option><option value="client" selected>Client</option>';
            } else if ($role == "S") {
                $html .= '<option value="admin">Admin</option><option value="staff" selected>Staff</option><option value="client">Client</option>';
            }
            $html .= <<<HTML
			</select>
		</p>
		<p>
			<input type="submit" name="OK" value="OK"> <input type="submit" name="Cancel" value="Cancel">
		</p>

	</fieldset>
</form>

	<p>
		Admin users have complete management of the system. Staff users are able to view and make
		reports for any client, but cannot edit the users. Clients can only view the cases
		they have contracted for.
	</p>
HTML;

            return $html;
        }



    }

    private $site;
}