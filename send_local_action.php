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

$json = $_GET['data'];
$point = json_decode($json);

$x = $point['x'];
$y = $point['y'];

echo $x;
echo " ";
echo $y;

$result = mysqli_query($con, "UPDATE matches SET player1_x='$x', player1_y='$y' WHERE id='0';")


?>