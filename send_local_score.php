<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 24/5/17
 * Time: 10:40
 */

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$con = new mysqli($server, $username, $password, $db);

$matchId = $_GET['matchId'];
$player = $_GET['player'];
$score = $_GET['score'];

$result = mysqli_query($con, "UPDATE matches SET player{$player}_score = {$score} WHERE id={$matchId};");

?>