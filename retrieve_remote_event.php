<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 14/5/17
 * Time: 18:01
 */

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$con = new mysqli($server, $username, $password, $db);

$matchId = $_GET['matchId'];
$player = $_GET['player'];

$result = mysqli_query($con, "SELECT player{$player}_eventIndex, player{$player}_event FROM matches WHERE id={$matchId};");
$row = mysqli_fetch_array($result);

$eventIndex = $row[0];
$event = $row[1];

$coordinates = ["eventIndex" => $eventIndex, "event" => $event];

echo json_encode($coordinates);

?>