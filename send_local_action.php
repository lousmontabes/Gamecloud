<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 29/3/17
 * Time: 12:53
 */

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$con = new mysqli($server, $username, $password, $db);

$matchId = $_GET['matchId'];
$player = $_GET['player'];
$x = $_GET['x'];
$y = $_GET['y'];

echo $x;
echo " ";
echo $y;

$result = mysqli_query($con, "UPDATE matches SET player{$player}_x={$x}, player{$player}_y={$y} WHERE id={$matchId};");


?>