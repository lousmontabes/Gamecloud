<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 30/3/17
 * Time: 13:24
 */

require_once("connection.php");

$con = getDatabaseConnection();

$result = mysqli_query($con,"INSERT INTO queue (id) VALUES (NULL)");

echo mysqli_insert_id($con);

?>