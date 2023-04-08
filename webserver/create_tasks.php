

<?php

function newTaskForm() {
	echo '<form action="/index.php">';
  	echo '<label for="tname">Task name:</label><br>';
  	echo '<input type="text"  name="tname" id="tname" value="Task1"><br><br>';
  	echo '<input type="submit" value="Submit">';
	echo '</form>';
}

function newSubtaskForm($task) {
	echo "<form action='/index.php'>";
  	echo "<label for='subtask$task'>Subtask for $task:</label><br>";
  	echo "<input type='text' name='subtask' id='subtask$task'>";
	echo "<input type='radio' id='subtask$task-radio' name='subtasktarget' value='$task' checked>";
  	echo "<input type='submit' value='Submit'>";
	echo "</form>";
}

function handleInput() {
	$tasks = array();

	// get existing tasks from cookie
	if(isset($_COOKIE['tname'])) {
		$tasks = json_decode($_COOKIE['tname'], true);
		if($tasks == null) {
			$tasks = array();
		}
	}

	// add new task from GET params
	if(isset($_GET['tname'])) {
		$tasks[$_GET["tname"]] = array();
		setcookie('tname', json_encode($tasks), time() + (86400 * 30), "/");
	}

	if(isset($_GET['subtask']) && isset($_GET['subtasktarget'])) {
		if(isset($tasks[$_GET['subtasktarget']])) {
			array_push($tasks[$_GET['subtasktarget']], $_GET['subtask']);
		}
		setcookie('tname', json_encode($tasks), time() + (86400 * 30), "/");
	}

	return $tasks;
}


?>
