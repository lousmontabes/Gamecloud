<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 30/3/17
 * Time: 18:38
 */

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$con = new mysqli($server, $username, $password, $db);

$result = mysqli_query($con, "SELECT id FROM match_requests");
$row = mysqli_fetch_array($result);

if (mysqli_num_rows($result) == 0){

    // There are no active match requests. Create a match request.

    $result = mysqli_query($con, "INSERT INTO match_requests(id) VALUE (null)");
    echo "{\"action\":0,\"index\":0}";

}else{

    // There are active match requests. Create a match for both players (the requester and the joiner) and
    // delete the request.

    $result = mysqli_query($con, "INSERT INTO matches(id) VALUE (null)");
    $matchId = mysqli_insert_id($con);

    $result = mysqli_query($con, "UPDATE match_requests SET assigned_match VALUE {$matchId}");

    echo "{\"action\":1,\"index\":{$matchId}}";

}

?>