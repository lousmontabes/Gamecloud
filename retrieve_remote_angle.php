<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 15/5/17
 * Time: 21:25
 */

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$con = new mysqli($server, $username, $password, $db);

$matchId = $_GET['matchId'];
$player = $_GET['player'];

$result = mysqli_query($con, "SELECT player{$player}_angle FROM matches WHERE id={$matchId};");
$row = mysqli_fetch_array($result);

$angle = $row[0];

$json = ["angle" => $x];

echo json_encode($json);

?>