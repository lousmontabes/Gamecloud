<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 24/5/17
 * Time: 10:40
 */

require_once("connection.php");

$con = getDatabaseConnection();

$matchId = $_GET['matchId'];
$player = $_GET['player'];
$score = $_GET['score'];

$result = mysqli_query($con, "UPDATE matches SET player{$player}_score = {$score} WHERE id={$matchId};");

?>