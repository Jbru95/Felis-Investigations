<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 3/21/2018
 * Time: 12:00 PM
 */

namespace Felis;


class CasesController{

    private $redirect;

    public function getRedirect() {
        return $this->redirect;
    }

    public function __construct($site, $post){
        $root = $site->getRoot();

        if(isset($post['add'])){
            $this->redirect = "$root/newcase.php";
        }
        else if (isset($post['delete']) and isset($post['user'])){

            $this->redirect = "$root/deletecase.php?id=".$post['user'];
        }
        else{
            $this->redirect = "$root/cases.php";
        }

    }


}