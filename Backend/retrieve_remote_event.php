<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 14/5/17
 * Time: 18:01
 */

require_once("connection.php");

$con = getDatabaseConnection();

$matchId = $_GET['matchId'];
$player = $_GET['player'];

$result = mysqli_query($con, "SELECT player{$player}_eventIndex, player{$player}_event FROM matches WHERE id={$matchId};");
$row = mysqli_fetch_array($result);

$eventIndex = $row[0];
$event = $row[1];

$json = ["eventIndex" => $eventIndex, "event" => $event];

echo json_encode($json);

?>