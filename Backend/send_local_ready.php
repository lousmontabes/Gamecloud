<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 22/5/17
 * Time: 14:39
 */

require_once("connection.php");

$con = getDatabaseConnection();

$matchId = $_GET['matchId'];
$player = $_GET['player'];
$ready = $_GET['ready'];

echo $ready;

$result = mysqli_query($con, "UPDATE matches SET player{$player}_ready={$ready}  WHERE id={$matchId};");

?>