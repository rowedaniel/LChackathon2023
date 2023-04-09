<link rel="stylesheet" type="text/css" href="style.css" />

<?php

include 'build_tree.php';

$tasks = handleInput();
buildTree($tasks);

newCityForm();

?>

<script src="script.js"></script>
