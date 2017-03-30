<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 30/3/17
 * Time: 15:53
 */

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$queueId = substr($_GET['id'], 0, -1);

if ($queueId % 2 == 1 || $queueId == ""){
    // If queue index is odd, actively look for an opponent.

    

}else{
    // If queue index is even, wait for an opponent to find you.



}

?>