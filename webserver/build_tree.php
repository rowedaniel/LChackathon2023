<?php
include 'create_tasks.php';

function buildTree($tasks) {
	// build tree from tasks

	// 'branches' should alternate left/right
	$directions = array('left', 'right');
	$direction_index = 0;

	echo "<ul id='tree'>";
	foreach($tasks as $task => $subtasks) {

		// alternate directions
		$direction_index = ($direction_index + 1) % count($directions);
		$direction = $directions[$direction_index];

		buildBranch($task, $subtasks, $direction);
	}
	echo "</ul>";
}

function buildBranch($task, $subtasks, $direction) {
	echo "<li class='$direction'>$task";
	echo "<ul class='branch'>";
	foreach($subtasks as $subtask => $finished) {
		buildLeaf($task, $subtask, $finished);
	}
	echo "</ul>";
	newSubtaskForm($task);
	echo "</li>";
}

function buildLeaf($task, $subtask, $finished) {
	if($finished) {
		echo "<li class='finished'>";
	} else {
		echo "<li class='unfinished'>";
	}

	echo $subtask;
	newDeleteSubtaskForm($task, $subtask);
	newFinishSubtaskForm($task, $subtask);

	echo "</li>";
}

?>
