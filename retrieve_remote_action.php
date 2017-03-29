<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 29/3/17
 * Time: 12:52
 */

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$con = new mysqli($server, $username, $password, $db);

$result = mysqli_query($con, "SELECT player1_x, player1_y FROM matches WHERE id='0';");
$row = mysqli_fetch_array($result);

$x = $row[0];
$y = $row[1];

$coordinates = ["x" => $x, "y" => $y];

echo json_encode($coordinates);

?>