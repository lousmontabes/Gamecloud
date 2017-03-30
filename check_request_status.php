<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 30/3/17
 * Time: 20:46
 */

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$con = new mysqli($server, $username, $password, $db);

$requestId = $_GET['requestId'];

$result = mysqli_query($con, "SELECT assigned_match FROM match_requests WHERE id = {$requestId}");
$row = mysqli_fetch_array($result);

echo $row[0];

?>