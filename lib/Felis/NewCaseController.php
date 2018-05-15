<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 3/24/2018
 * Time: 7:54 PM
 */

namespace Felis;


class NewCaseController{

    private $redirect;

    public function getRedirect() {
        return $this->redirect;
    }

    public function __construct($site, $user, $post){
        $root = $site->getRoot();
        if(!isset($post['ok'])) {
            $this->redirect = "$root/cases.php";
            return ;
        }

        $cases = new Cases($site);
        $id = $cases->insert(strip_tags($post['client']),
            $user->getId(),
            strip_tags($post['number']));

        if($id === null) {
            $this->redirect = "$root/newcase.php?e";
        }
        else{
            $this->redirect = "$root/case.php?id=$id";
        }
    }

}