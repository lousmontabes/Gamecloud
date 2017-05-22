<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 22/5/17
 * Time: 14:37
 */

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$con = new mysqli($server, $username, $password, $db);

$matchId = $_GET['matchId'];
$player = $_GET['player'];

$result = mysqli_query($con, "SELECT player{$player}_ready FROM matches WHERE id={$matchId};");
$row = mysqli_fetch_array($result);

$ready = $row[0];

//$json = ["ready" => $ready];

echo $ready;

?>