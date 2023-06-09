

<?php

function newCityForm() {
	echo "<form action='/index.php'>";
  	echo "<label for='city'>City:</label><br>";
  	echo "<input type='text' name='city' id='city' value='Portland'>";
  	echo "<input type='submit' value='Submit'>";
	echo "</form>";
}

function newTaskForm() {
	echo '<form action="/index.php">';
  	echo '<label for="tname">Task name:</label><br>';
  	echo '<input type="text"  name="tname" id="tname" value="Task1"><br><br>';
  	echo '<input type="submit" value="Submit">';
	echo '</form>';
}

function newSubtaskForm($task) {
	echo "<form action='/index.php'>";
  	echo "<label for='task-$task-newsubtaskname'>Subtask for $task:</label><br>";
  	echo "<input type='text' name='subtask' id='task-$task-newsubtaskname'>";
	echo "<input type='radio' style='display: none' name='subtasktarget' value='$task' checked>";
  	echo "<input type='submit' value='Submit'>";
	echo "</form>";
}

function newDeleteSubtaskForm($task, $subtask) {
	echo "<form action='/index.php'>";
	echo "<input type='radio' style='display: none' name='subtaskdelete' value='$task-$subtask' checked>";
	echo "<input type='submit' value='delete task'>";
	echo "</form>";
}

function newFinishSubtaskForm($task, $subtask) {
	echo "<form action='/index.php'>";
	echo "<input type='radio' style='display: none' name='subtaskfinish' value='$task-$subtask' checked>";
	echo "<input type='submit' value='finish task'>";
	echo "</form>";
}

function saveTasksToCookie($tasks) {
	setcookie('tname', json_encode($tasks), time() + (86400 * 30), "/");
}

function saveRewardToCookie($task, $reward) {
	setcookie("reward-$task", json_encode($reward), time() + (86400 * 30), "/");
}

function getTasksFromCookie() {
	// get existing tasks from cookie
	$tasks = array();
	if(isset($_COOKIE['tname'])) {
		$tasks = json_decode($_COOKIE['tname'], true);
		if($tasks == null) {
			$tasks = array();
		}
	}
	saveTasksToCookie($tasks);
	return $tasks;
}

function getCityFromCookie() {
	// get existing city from cookie
	$city = "Portland";
	if(isset($_COOKIE['city'])) {
		$city = $_COOKIE['city'];
	}
	return $city;
}

function getRewardFromCookie($task) {
	// get existing reward from cookie
	$reward = "";
	if(isset($_COOKIE["reward-$task"])) {
		$reward = json_decode($_COOKIE["reward-$task"], true);
		if($reward == null) {
			$reward = "";
		}
	}
	return $reward;
}

function handleCity() {
	// set city from GET params
	if(isset($_GET['city'])) {
		setcookie('city', $_GET['city'], time() + (86400 * 30), "/");
	}
}

function handleNewTask($tasks, $city) {
	// add new task from GET params
	if(!isset($_GET['tname'])) {
		return $tasks;
	}
	$tasks[$_GET["tname"]] = array();
	saveTasksToCookie($tasks);

	// get food reward
	$response = json_decode(file_get_contents("http://localhost:8000/$city"));
	saveRewardToCookie($_GET["tname"], $response);
	return $tasks;
}

function handleNewSubtask($tasks) {
	// make sure the subtask is properly specified and not in the list already
	if(!isset($_GET['subtask']) || !isset($_GET['subtasktarget'])) {
		return $tasks;
	}
	$task = $_GET['subtasktarget'];
	$subtask = $_GET['subtask'];
	if(!isset($tasks[$task])) {
		return $tasks;
	}
	if(isset($tasks[$task][$subtask])) {
		return $tasks;
	}

	// add new subtask from GET params
	$tasks[$task][$subtask] = false;
	saveTasksToCookie($tasks);
	return $tasks;
}

function handleDeleteSubtask($tasks) {
	// make sure subtask is properly specified
	if(!isset($_GET['subtaskdelete'])) {
		return $tasks;
	}
	$components = explode('-', $_GET['subtaskdelete']);
	if(count($components) != 2) {
		return $tasks;
	}
	$task = $components[0];
	$subtask = $components[1];

	// make sure task and subtask exist
	if(!isset($tasks[$task]) || !isset($tasks[$task][$subtask])) {
		return $tasks;
	}

	unset($tasks[$task][$subtask]);

	// delete entire task if no subtasks left
	if(count($tasks[$task]) == 0) {
		unset($tasks[$task]);
	}
	saveTasksToCookie($tasks);
	return $tasks;
}

function handleMarkSubtaskCompleted($tasks) {
	// make sure subtask is properly specified
	if(!isset($_GET['subtaskfinish'])) {
		return $tasks;
	}
	$components = explode('-', $_GET['subtaskfinish']);
	if(count($components) != 2) {
		return $tasks;
	}
	$task = $components[0];
	$subtask = $components[1];

	// make sure task and subtask exist
	if(!isset($tasks[$task]) || !isset($tasks[$task][$subtask])) {
		return $tasks;
	}

	$tasks[$task][$subtask] = !$tasks[$task][$subtask];
	saveTasksToCookie($tasks);
	return $tasks;


}

function handleInput() {
	// get city
	handleCity();
	$city = getCityFromCookie();
	
	// get tasks
	$tasks = getTasksFromCookie();
	$tasks = handleNewTask($tasks, $city);
	$tasks = handleNewSubtask($tasks);
	$tasks = handleDeleteSubtask($tasks);
	$tasks = handleMarkSubtaskCompleted($tasks);

	return $tasks;
}


?>
