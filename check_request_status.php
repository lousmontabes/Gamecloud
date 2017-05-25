<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 30/3/17
 * Time: 20:46
 */

require_once("connection.php");

$con = getDatabaseConnection();

$requestId = $_GET['requestId'];

$result = mysqli_query($con, "SELECT assigned_match FROM match_requests WHERE id = {$requestId}");
$row = mysqli_fetch_array($result);

echo $row[0];

?>