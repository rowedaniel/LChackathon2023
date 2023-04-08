<?php

include 'build_tree.php';

$tasks = handleInput();
buildTree($tasks);

newTaskForm();

?>
