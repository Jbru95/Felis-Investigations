<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 3/21/2018
 * Time: 11:08 AM
 */

namespace Felis;


class ClientCase{

    const STATUS_OPEN = "O"; // case is open
    const STATUS_CLOSED = "C"; //case is closed

    private $id;
    private $client;
    private $clientName;
    private $agent;
    private $agentName;
    private $number;
    private $summary;
    private $status;

    public function __construct($row){
        $this->id = $row['id'];
        $this->client = $row['client'];
        $this->clientName = $row['clientName'];
        $this->agent = $row['agent'];
        $this->agentName = $row['agentName'];
        $this->number = $row['number'];
        $this->summary = $row['summary'];
        $this->status = $row['status'];
    }


    public function getId(){
        return $this->id;
    }

    public function getClient(){
        return $this->client;
    }

    public function getClientName(){
        return $this->clientName;
    }

    public function getAgent(){
        return $this->agent;
    }

    public function getAgentName(){
        return $this->agentName;
    }

    public function getNumber(){
        return $this->number;
    }

    public function getSummary(){
        return $this->summary;
    }

    public function getStatus(){
        return $this->status;
    }

    public function setStatus($status){
        $this->status = $status;
    }

    public function setAgent($agentId){
        $this->agent = $agentId;
    }

    public function setSummary($summary){
        $this->summary = $summary;
    }

    public function setNumber($number){
        $this->number = $number;
    }
}