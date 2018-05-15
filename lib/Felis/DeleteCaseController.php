<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 3/25/2018
 * Time: 6:55 PM
 */

namespace Felis;


class DeleteCaseController{

    private $redirect;

    public function getRedirect() {
        return $this->redirect;
    }

    public function __construct($site, $post){

        $cases = new Cases($site);
        $root = $site->getRoot();

        if(isset($post["Yes"]) and isset($post['id'])){
            $id = $post['id'];
            $cases->delete($id);
        }

        $this->redirect = "$root/cases.php";
    }
}