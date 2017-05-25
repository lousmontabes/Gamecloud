<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 29/3/17
 * Time: 12:52
 */

include("connection.php");

$con = connectToDatabase();

$matchId = $_GET['matchId'];
$player = $_GET['player'];

$result = mysqli_query($con, "SELECT player{$player}_x, player{$player}_y, player{$player}_angle FROM matches WHERE id={$matchId};");
$row = mysqli_fetch_array($result);

$x = $row[0];
$y = $row[1];
$angle = $row[2];

$coordinates = ["x" => $x, "y" => $y, "angle" => $angle];

echo json_encode($coordinates);

?>