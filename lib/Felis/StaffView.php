<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 3/13/2018
 * Time: 7:06 PM
 */

namespace Felis;


class StaffView extends View{

    public function __construct(){

        $this->setTitle('Felis Staff');
        $this->addLink('post/logout.php','Log out');

    }

}