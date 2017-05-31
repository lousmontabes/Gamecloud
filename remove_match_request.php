<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 30/5/17
 * Time: 9:14
 */

require_once("connection.php");
$con = getDatabaseConnection();

$requestId = $_GET['requestId'];
echo $requestId;

mysqli_query($con, "DELETE FROM match_requests WHERE id = {$requestId}");

?>