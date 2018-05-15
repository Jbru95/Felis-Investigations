<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 3/14/2018
 * Time: 7:14 PM
 */

namespace Felis;


class Users extends Table{

    public function __construct(Site $site) {
        parent::__construct($site, "user");
    }


    /**
     * Modify a user record based on the contents of a User object
     * @param User $user User object for object with modified data
     * @return true if successful, false if failed or user does not exist
     */
    public function update(User $user){

        $sql = <<<SQL
UPDATE $this->tableName
SET email=?, name=?, phone=?, address=?, notes=?, role=?
WHERE id=?
SQL;
        $ret = false;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);


        try {
            $ret = $statement->execute(array($user->getEmail(), $user->getName(), $user->getPhone(), $user->getAddress(), $user->getNotes(), $user->getRole(), $user->getId()));
            if($statement->rowCount() === 0) {
                $ret = false;
            }
        } catch(\PDOException $e) {
            return false;
        }

        return $ret;
    }


    //Test for valid login credentials
    /**
     * Test for a valid login.
     * @param $email User email
     * @param $password Password credential
     * @returns User object if successful, null otherwise.
     */
    public function login($email, $password) {
        $sql =<<<SQL
SELECT * from $this->tableName
where email=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($email));
        if($statement->rowCount() === 0) {
            return null;
        }

        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        // Get the encrypted password and salt from the record
        $hash = $row['password'];
        $salt = $row['salt'];

        // Ensure it is correct
        if($hash !== hash("sha256", $password . $salt)) {
            return null;
        }

        return new User($row);
    }

    public function exists($email) {
        $sql =<<<SQL
SELECT * from $this->tableName
where email=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($email));
        if($statement->rowCount() === 0) {
            return false;
        }
        else{
            return true;
        }
    }


    /**
     * Get a user based on the id
     * @param $id ID of the user
     * @returns User object if successful, null otherwise.
     */
    public function get($id) {
        $sql =<<<SQL
SELECT * FROM $this->tableName
WHERE id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }

        return new User($statement->fetch(\PDO::FETCH_ASSOC));
    }


    public function getClients(){

        $sql = <<<SQL
SELECT id, name
FROM $this->tableName
WHERE role='C'
SQL;

        $clientArray = array();
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute();
        if($statement->rowCount() === 0){
            return null;
        }

        return $statement->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function getUsers(){
        $sql = <<<SQL
SELECT *
FROM $this->tableName
ORDER BY role, name
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute();
        if($statement->rowCount() === 0){
            return null;
        }

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAgents(){//gets agents and admins

        $sql = <<<SQL
SELECT id, name
FROM $this->tableName
WHERE role='A' or role='S'
SQL;

        $clientArray = array();
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute();
        if($statement->rowCount() === 0){
            return null;
        }

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function add(User $user, Email $mailer){
        //Ensure we dont have a duplicate email address
        if ($this->exists($user->getEmail())){
            return "Email address already exists.";
        }

        //Add a record to the user table
        $sql = <<<SQL
INSERT INTO $this->tableName(email, name, phone, address, notes, joined, role)
values(?, ?, ?, ?, ?, ?, ?)
SQL;
        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array(
            $user->getEmail(), $user->getName(), $user->getPhone(), $user->getAddress(),
            $user->getNotes(), date("Y-m-d H:i:s"), $user->getRole()));
        $id = $this->pdo()->lastInsertId();

        //Create a Validator and add to the validator table
        $validators = new Validators($this->site);
        $validator = $validators->newValidator($id);

        //Send email with the validator in it
        $link = "http://webdev.cse.msu.edu"  . $this->site->getRoot() . '/password-validate.php?v=' . $validator;
        $from = $this->site->getEmail();
        $name = $user->getName();

        $subject = "Confirm your email";
        $message = <<<MSG
<html>
<p>Greetings, $name,</p>

<p>Welcome to Felis. In order to complete your registration,
please verify your email address by visiting the following link:</p>

<p><a href="$link">$link</a></p>
</html>
MSG;
        $headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso=8859-1\r\nFrom: $from\r\n";
        $mailer->mail($user->getEmail(), $subject, $message, $headers);
    }

    public static function randomSalt($len = 16) {
        $bytes = openssl_random_pseudo_bytes($len / 2);
        return bin2hex($bytes);
    }
    /**
     * Set the password for a user
     * @param $userid ID for the user
     * @param $password password to set
     */
    public function setPassword($userid, $password) {

        $sql=<<<SQL
UPDATE $this->tableName
SET password=?, salt=?
WHERE id=?
SQL;
        $statement = $this->pdo()->prepare($sql);

        $salt = self::randomSalt();
        $hash = hash('sha256', $password . $salt);
        //$pass = $password.$salt;

        $ret = false;
        try {
            $ret = $statement->execute(array($hash, $salt, $userid));
            if($statement->rowCount() === 0) {
                $ret = false;
            }
        } catch(\PDOException $e) {
            return false;
        }
        return $ret;
    }

    public function delete($id){

        $sql = <<<SQL
DELETE FROM $this->tableName
WHERE validator=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
    }
}