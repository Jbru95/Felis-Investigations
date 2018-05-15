<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 3/25/2018
 * Time: 6:55 PM
 */

namespace Felis;


class DeleteCaseView extends View{

    private $site;
    private $caseId;

    public function __construct($site, $get){

        if (isset($get['id'])){
            $this->caseId = $get['id'];
        }
        $this->site = $site;
        $this->setTitle("Felis Delete?");
        $this->addLink('staff.php', "Staff");
        $this->addLink('cases.php', 'Cases');
        $this->addLink('post/logout.php','Log out');
    }

    public function present(){

        $cases = new Cases($this->site);
        $case = $cases->get($this->caseId);
        $caseNum = $case->getNumber();

        $html = <<<HTML
<form method="post" action="post/deletecase.php">
	<fieldset>
		<legend>Delete?</legend>
		<p>Are you sure absolutely certain beyond a shadow of
			a doubt that you want to delete case $caseNum?</p>

		<p>Speak now or forever hold your peace.</p>

		<p><input type="submit" name="Yes" value="Yes"> <input type="submit" name="No" value="No"></p>
		<input type="hidden" name="id" value="$this->caseId">

	</fieldset>
</form>
HTML;
        return $html;
    }
}