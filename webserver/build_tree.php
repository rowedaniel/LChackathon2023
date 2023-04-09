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
	
	$inspQuotes = ["Failure at some point in your life is inevitable, but giving up is unforgivable.", "Folks, I can tell you I've known eight presidents, three of them intimately.", "My father used to have an expression. He'd say, 'Joey, a job is about a lot more than a paycheck. It's about your dignity. It's about respect. It's about your place in your community.'", "If I don't run for president, we'll all be OK.", "Osama bin Laden is dead and General Motors is alive.", "I know I'm not supposed to like muscle cars, but I like muscle cars.", "I'm not big on flak jackets and tie-dyed shirts. You know, that's not me.", "For too long in this society, we have celebrated unrestrained individualism over common community.", "I was kind of secretly hoping one of my kids would go out and make a million bucks. So when they put me in a home, at least I'll have a window with a view.", "America doesn't have health insurance.", "I guess every single word I've ever said is going to be dissected now.", "We're going to be OK because of the American people. They have more grit, determination and courage than you can imagine.", "I know why we're strong. I know why we have held together; I know why we are united: it's because there's always been a growing middle class.", "You've got to reach a hand of friendship across the aisle and across philosophies in this country.", "During the 60's, I was, in fact, very concerned about the civil rights movement."];
	$quote = $inspQuotes[rand(0, count($inspQuotes))-1];
	echo "<div class='blurb' id='blurb-$task-$subtask'>";
	echo "<h1>$quote <i>-Joe Biden</i></h1>";
	echo "<img src='image.jpg' alt='joey'>";
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
