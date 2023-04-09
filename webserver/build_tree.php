<?php
include 'create_tasks.php';

function buildFoodBlurb($city, $task, $subtask) {
	$data = getRewardFromCookie($task);
	if($data == null || !isset($data['title']) || !isset($data['image']) || !isset($data['link'])) {
		return;
	}

	$title = $data['title'];
	$image = $data['image'];
	$link = $data['link'];

	echo "<div class='blurb' id='blurb-$task-$subtask'>";
	echo "<h1>$title</h1>";
	echo "<a href='$link'> <img src='$image' alt='$title'> </a>";
	echo "</div>";
}

function buildInspirationalBlurb($task, $subtask) {
	echo "<div class='blurb' id='blurb-$task-$subtask'>";
	echo "<h1>Inspirational Quote</h1>";
	echo "<img src='$image' alt='$title'>";
	echo "</div>";
}

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
	newTaskForm();
}

function buildBranch($task, $subtasks, $direction) {
	echo "<li class='$direction'>$task";
	echo "<ul class='branch'>";

	// check if all finished
	$all_finished = true;
	foreach($subtasks as $subtask => $finished) {
		if(!$finished) {
			$all_finished = false;
		}
	}
	foreach($subtasks as $subtask => $finished) {
		buildLeaf($task, $subtask, $finished, $all_finished);
	}
	echo "</ul>";
	newSubtaskForm($task);
	echo "</li>";
}

function buildLeaf($task, $subtask, $finished, $all_finished) {
	if($finished) {
		echo "<li class='subtask finished'>";
	} else {
		echo "<li class='subtask unfinished'>";
	}

	echo $subtask;
	newDeleteSubtaskForm($task, $subtask);
	newFinishSubtaskForm($task, $subtask);

	if($all_finished) {
		buildFoodBlurb($city, $task, $subtask);
	} else {
		buildInspirationalBlurb($task, $subtask);
	}

	echo "</li>";
}

?>
