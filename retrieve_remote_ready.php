<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 22/5/17
 * Time: 14:37
 */

require_once("connection.php");

$con = getDatabaseConnection();

$matchId = $_GET['matchId'];
$player = $_GET['player'];

$result = mysqli_query($con, "SELECT player{$player}_ready FROM matches WHERE id={$matchId};");
$row = mysqli_fetch_array($result);

$ready = $row[0];

//$json = ["ready" => $ready];

echo $ready;

?>