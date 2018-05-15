<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 3/21/2018
 * Time: 11:20 AM
 */

namespace Felis;


class Cases extends Table{

    public function __construct(Site $site) {
        parent::__construct($site, "case");
    }


    public function get($id) {
        $users = new Users($this->site);
        $usersTable = $users->getTableName();

        $sql = <<<SQL
SELECT c.id, c.client, client.name as clientName,
       c.agent, agent.name as agentName,
       number, summary, status
from $this->tableName c,
     $usersTable client,
     $usersTable agent
where c.client = client.id and
      c.agent=agent.id and
      c.id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }

        return new ClientCase($statement->fetch(\PDO::FETCH_ASSOC));
    }


    public function insert($client, $agent, $number){
        $sql = <<<SQL
insert into $this->tableName(client, agent, number, summary, status)
values(?, ?, ?, "", ?)
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            if($statement->execute(array($client,
                        $agent,
                        $number,
                        ClientCase::STATUS_OPEN)
                ) === false) {
                return null;
            }
        } catch(\PDOException $e) {
            return null;
        }

        return $pdo->lastInsertId();
    }

    public function getCases(){
        $users = new Users($this->site);
        $usersTable = $users->getTableName();
        $casesAry = array();

        $sql = <<<SQL
SELECT c.id, c.client, client.name as clientName,
       c.agent, agent.name as agentName,
       number, summary, status
FROM $this->tableName c
INNER JOIN $usersTable client
ON c.client = client.id
INNER JOIN $usersTable agent
ON c.agent = agent.id
ORDER BY status DESC, number 
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute();
        if($statement->rowCount() === 0) {
            return null;
        }

        $rawCases = $statement->fetchAll(\PDO::FETCH_ASSOC);
        //echo var_dump($rawCases);
        foreach($rawCases as $case){
            $casesAry[] = new ClientCase($case);
        }

        return $casesAry;
    }

    public function update(ClientCase $case){

        $sql = <<<SQL
UPDATE $this->tableName
SET number=?, summary=?, agent=?, status=?
WHERE id=?
SQL;
        $ret = false;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);


        try {
            $ret = $statement->execute(array($case->getNumber(),
                $case->getSummary(),
                $case->getAgent(),
                $case->getStatus(),
                $case->getId()));

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
WHERE id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
    }

}