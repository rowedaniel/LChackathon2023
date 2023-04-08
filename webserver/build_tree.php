<?php
include 'create_tasks.php';

function buildTree($tasks) {
	// builds tree from cookies
	echo "<ul>";
	foreach($tasks as $task => $subtasks) {
		echo "<li>$task";
		echo "<ul>";
		foreach($subtasks as $subtask) {
			echo "<li>$subtask</li>";
		}
		echo "</ul>";
		newSubtaskForm($task);
		echo "</li>";
	}
	echo "</ul>";
}

?>
