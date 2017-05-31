<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 15/5/17
 * Time: 21:25
 */

require_once("connection.php");

$con = getDatabaseConnection();

$matchId = $_GET['matchId'];
$player = $_GET['player'];

$result = mysqli_query($con, "SELECT player{$player}_angle FROM matches WHERE id={$matchId};");
$row = mysqli_fetch_array($result);

$angle = $row[0];

$json = ["angle" => $angle];

echo json_encode($json);

?>