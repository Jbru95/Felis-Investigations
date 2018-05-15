<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 3/13/2018
 * Time: 5:25 PM
 */

namespace Felis;


class HomeView extends View{

    private $tests = array();

    public function __construct(){
        $this->setTitle("Felis Investigations");
        $this->addLink("login.php", "Log in");
    }


    protected function headerAdditional(){

        return <<<HTML
<p>Welcome to Felis Investigations!</p>
<p>Domestic, divorce, and carousing investigations conducted without publicity. People and cats shadowed
	and investigated by expert inspectors. Katnapped kittons located. Missing cats and witnesses located.
	Accidents, furniture damage, losses by theft, blackmail, and murder investigations.</p>
<p><a href="">Learn more</a></p>
HTML;
    }

    public function addTestimonial($text, $author){

        $this->tests[] = array("text" => $text, "author" => $author);
    }

    public function testimonials(){
        $left_bool = true;
        $left_tests = array();
        $right_tests = array();

        if (count($this->tests) == 0){
            return "";
        }

        foreach ($this->tests as $elem){
            if($left_bool == true){
                $left_tests[] = $elem;
                $left_bool = false;
            }
            else{
                $right_tests[] = $elem;
                $left_bool = true;
            }
        }

        $html = '<section class="testimonials"><h2>TESTIMONIALS</h2><div class="left">';
        foreach($left_tests as $lelem){
            $html .= '<blockquote><p>'.$lelem["text"].'</p><cite>'.$lelem["author"].'</cite></blockquote>';
        }

        $html .= '</div><div class="right">';

        foreach($right_tests as $relem){
            $html .= '<blockquote><p>'.$relem["text"].'</p><cite>'.$relem["author"].'</cite></blockquote>';
        }

        $html .= '</div></section>';

        return $html;
    }
}