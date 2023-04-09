<link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet'>
<link rel="stylesheet" type="text/css" href="style.css" />

<?php
echo "<h1>Fruitful Thinking</h1>";
include 'build_tree.php';

$tasks = handleInput();
buildTree($tasks);

newCityForm();

?>

<script src="script.js"></script>
