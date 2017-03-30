<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 30/3/17
 * Time: 15:48
 */

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$con = new mysqli($server, $username, $password, $db);

$id = $_GET['id'];

$result = mysqli_query($con,"DELETE FROM queue WHERE id = $id");

echo mysqli_insert_id($con);

?>