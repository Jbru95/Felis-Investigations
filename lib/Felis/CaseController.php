<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 3/25/2018
 * Time: 2:04 PM
 */

namespace Felis;


class CaseController{

    private $redirect;

    public function getRedirect() {
        return $this->redirect;
    }

    public function __construct($site, $post, $get){//needs changes
        $root = $site->getRoot();



        if(isset($post['Update'])) {//if update submit button is clicked

            $id = $post['id'];
            $cases = new Cases($site);
            $case = $cases->get($id);
            $caseNumCheckAry = $cases->getCases();

            $users = new Users($site);
            $agentsCheck = $users->getAgents();


            foreach ($caseNumCheckAry as $caseCheck){
                if ($post['number'] == $caseCheck->getNumber() and $post['number'] != $case->getNumber()) {
                    $this->redirect = "$root/case.php?id=" . $id;
                    return;
                }
            }

            if($post['status'] == "Open"){//setting status(O,C) based on input from form
                $case->setStatus("O");
            }
            else if ($post['status'] == "Closed"){
                $case->setStatus("C");
            }

            $case->setAgent($post['agent']);
            $case->setNumber(strip_tags($post['number']));
            $case->setSummary(strip_tags($post['summary']));

            $cases->update($case);

            $this->redirect = "$root/cases.php";
        }

    }
}