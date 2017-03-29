<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 29/3/17
 * Time: 12:52
 */

$x = rand(10, 100);
$y = rand(10, 100);

$coordinates = ["x" => $x, "y" => $y];

return json_encode($coordinates);

?>