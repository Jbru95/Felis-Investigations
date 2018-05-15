<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
class SiteTest extends \PHPUnit_Framework_TestCase
{
	public function test1() {

	    $site = new \Felis\Site();

	    $site->setEmail('emailtest@gmail.com');
        $site->setRoot('1337');
        $site->dbConfigure("host", "user", "pass", "prefix_test");

        $this->assertEquals('emailtest@gmail.com',$site->getEmail());
        $this->assertEquals('1337',$site->getRoot());
        $this->assertEquals('prefix_test', $site->getTablePrefix());
	}

    public function test_localize() {
        $site = new Felis\Site();
        $localize = require 'localize.inc.php';
        if(is_callable($localize)) {
            $localize($site);
        }
        $this->assertEquals('test_', $site->getTablePrefix());
    }
}

/// @endcond
