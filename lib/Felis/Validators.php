<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 3/26/2018
 * Time: 12:07 AM
 */

namespace Felis;


class Validators extends Table {

    public function __construct(Site $site) {
        parent::__construct($site, "validator");
    }

    public function newValidator($userid){
        $validator = $this->createValidator();

        $sql = <<<SQL
INSERT INTO $this->tableName(validator, userid, date)
VALUES (?, ?, ?)
SQL;
        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($validator, $userid, date("Y-m-d H:i:s")));

        return $validator;
    }

    public function createValidator($len = 32) {
        $bytes = openssl_random_pseudo_bytes($len / 2);//secure random sequence of bytes
        return bin2hex($bytes);//convert to hexadecimal values for easier parsing
    }

    /**
     * Determine if a validator is valid. If it is,
     * return the user ID for that validator.
     * @param $validator Validator to look up
     * @return User ID or null if not found.
     */
    public function get($validator) {
        $sql =<<<SQL
SELECT * FROM $this->tableName
WHERE validator=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($validator));
        if($statement->rowCount() === 0) {
            return null;
        }
        $validatorAry = $statement->fetch(\PDO::FETCH_ASSOC);

        return $validatorAry['userid'];

    }

    /**
     * Remove any validators for this user ID.
     * @param $userid The USER ID we are clearing validators for.
     */
    public function remove($userid) {
        $sql = <<<SQL
DELETE FROM $this->tableName
WHERE userid=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($userid));
    }
}