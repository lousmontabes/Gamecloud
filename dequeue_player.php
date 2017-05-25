<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 30/3/17
 * Time: 15:48
 */

require_once("connection.php");

$con = getDatabaseConnection();
$id = $_GET['id'];

$result = mysqli_query($con,"DELETE FROM queue WHERE id = $id");

echo mysqli_insert_id($con);

?>