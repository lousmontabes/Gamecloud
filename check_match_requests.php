<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 30/3/17
 * Time: 18:38
 */

require_once("connection.php");

$con = getDatabaseConnection();

$result = mysqli_query($con, "SELECT id FROM match_requests WHERE status = 'OPEN' LIMIT 1");
$row = mysqli_fetch_array($result);

if (mysqli_num_rows($result) == 0){

    // There are no active match requests. Create a match request.

    $result = mysqli_query($con, "INSERT INTO match_requests(id) VALUE (null)");
    $requestId = mysqli_insert_id($con);

    echo "{\"action\":0,\"index\":{$requestId}}";

}else{

    // There are active match requests. Create a match for both players (the requester and the joiner) and
    // delete the request.

    $result = mysqli_query($con, "INSERT INTO matches(id) VALUE (null)");
    $matchId = mysqli_insert_id($con);

    $result = mysqli_query($con, "UPDATE match_requests SET assigned_match = {$matchId} WHERE id = {$row['id']}");
    $result = mysqli_query($con, "UPDATE match_requests SET status = 'CLOSED' WHERE id = {$row['id']}");

    echo "{\"action\":1,\"index\":{$matchId}}";

}

?>