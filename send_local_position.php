<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 29/3/17
 * Time: 12:53
 */

include("connection.php");

$con = connectToDatabase();

$matchId = $_GET['matchId'];
$player = $_GET['player'];
$x = $_GET['x'];
$y = $_GET['y'];
$angle = $_GET['angle'];

echo $x . " " . $y . " " . $angle;

$result = mysqli_query($con, "UPDATE matches SET player{$player}_x={$x}, player{$player}_y={$y}, player{$player}_angle={$angle} WHERE id={$matchId};");


?>