<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 3/15/2018
 * Time: 7:20 PM
 */

namespace Felis;


class User{

    const ADMIN = "A";
    const STAFF = "S";
    const CLIENT = "C";
    const SESSION_NAME = 'user';

    private $id;
    private $email;		///< Email address
    private $name; 		///< Name as last, first
    private $phone; 	///< Phone number
    private $address;	///< User address
    private $notes;		///< Notes for this user
    private $joined;	///< When user was added
    private $role;		///< User role

    public function __construct($row) {
        $this->id = $row['id'];
        $this->email = $row['email'];
        $this->name = $row['name'];
        $this->phone = $row['phone'];
        $this->address = $row['address'];
        $this->notes = $row['notes'];
        $this->joined = strtotime($row['joined']);
        $this->role = $row['role'];
    }

    public function getId(){
        return $this->id;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getName(){
        return $this->name;
    }

    public function getPhone(){
        return $this->phone;
    }

    public function getAddress(){
        return $this->address;
    }

    public function getNotes(){
        return $this->notes;
    }

    public function getJoined(){
        return $this->joined;
    }

    public function getRole(){
        return $this->role;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function setPhone($phone){
        $this->phone = $phone;
    }

    public function setAddress($address){
        $this->address = $address;
    }

    public function setNotes($notes){
        $this->notes = $notes;
    }

    public function setRole($role){
        $this->role = $role;
    }

    /**
     * Determine if user is a staff member
     * @return bool True if user is a staff member
     */
    public function isStaff() {
        return $this->role === self::ADMIN || $this->role === self::STAFF;
    }
}