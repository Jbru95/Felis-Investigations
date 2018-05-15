<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 3/14/2018
 * Time: 6:20 PM
 */

/**
 * Function to localize our site
 * @param $site The Site object
 */
return function(Felis\Site $site) {

    // Set the time zone
    date_default_timezone_set('America/Detroit');
    $site->setEmail('armbru43@cse.msu.edu');
    $site->setRoot('/~armbru43/step8');
    $site->dbConfigure('mysql:host=mysql-user.cse.msu.edu;dbname=armbru43',
        'armbru43',       // Database user
        'tiltedtowers',     // Database password
        'test8_');            // Table prefix
};