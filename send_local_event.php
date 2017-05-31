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
$event = $_GET['event'];
$eventIndex = $_GET['eventIndex'];

echo $eventIndex . ": " . $event;

$result = mysqli_query($con, "UPDATE matches SET player{$player}_event={$event}, player{$player}_eventIndex={$eventIndex} WHERE id={$matchId};");

?>