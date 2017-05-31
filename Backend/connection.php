<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 25/5/17
 * Time: 12:40
 */


function getDatabaseConnection(){
    $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

    $server = $url["host"];
    $username = $url["user"];
    $password = $url["pass"];
    $db = substr($url["path"], 1);

    return new mysqli($server, $username, $password, $db);
}

?>