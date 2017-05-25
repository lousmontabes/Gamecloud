<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 30/3/17
 * Time: 15:53
 */

require_once("connection.php");

$con = getDatabaseConnection();

$queueId = substr($_GET['id'], 0, -1);

if ($queueId % 2 == 1 || $queueId == ""){
    // If queue index is odd, actively look for an opponent.

    

}else{
    // If queue index is even, wait for an opponent to find you.



}

?>