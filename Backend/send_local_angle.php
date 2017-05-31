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
$angle = $_GET['angle'];

echo $angle;

$result = mysqli_query($con, "UPDATE matches SET player{$player}_angle={$angle}  WHERE id={$matchId};");

?>