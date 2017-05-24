<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 24/5/17
 * Time: 10:43
 */

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$con = new mysqli($server, $username, $password, $db);

$matchId = $_GET['matchId'];

$result = mysqli_query($con, "SELECT player1_score, player2_score FROM matches WHERE id={$matchId};");
$row = mysqli_fetch_array($result);

$player1Score = $row[0];
$player2Score = $row[1];

$json = ["score1" => $player1Score, "score2" => $player2Score];

echo json_encode($json);

?>