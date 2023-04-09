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
	echo "<img src='rootskeleton1.png' class='roots' alt='tree roots <3'>";
	foreach($tasks as $task => $subtasks) {

		// alternate directions
		$direction_index = ($direction_index + 1) % count($directions);
		$direction = $directions[$direction_index];

		buildBranch($task, $subtasks, $direction);
	}
	echo "<img src='crownskeleton1.png' class='crown' alt='tree crown'";
	echo "</ul>";
	newTaskForm();
}

function buildBranch($task, $subtasks, $direction) {
	echo "<div class='trunk'>";
	echo "<img src='" . $direction . "trunk.png' alt='tree roots <3'>";
	echo "<div class='$direction task'>";
	echo "<h2>$task</h2>";
	echo "<div>";

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
	newSubtaskForm($task);
	echo "</div>";
	echo "</div>";
	echo "</div>";
}

function buildLeaf($task, $subtask, $finished, $all_finished) {
	if($finished) {
		echo "<span class='subtask finished'>";
	} else {
		echo "<span class='subtask unfinished'>";
	}

	echo "<div>";
	echo "<img src='rightbranchskeleton.png' alt='leaf' class='branch'>";
	echo "<img src='leaf set 4.png' alt='leaf' class='decoration'>";
	echo "</div>";

	echo "<div class='text'>";
	echo "<h3>$subtask</h3>";
	newDeleteSubtaskForm($task, $subtask);
	newFinishSubtaskForm($task, $subtask);

	if($all_finished) {
		buildFoodBlurb($city, $task, $subtask);
	} else {
		buildInspirationalBlurb($task, $subtask);
	}
	echo "</div>";

	echo "</span>";
}

?>
