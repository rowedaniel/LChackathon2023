
document.addEventListener('DOMContentLoaded', function() {
	for(let subtask of document.querySelectorAll('.subtask')) {
		subtask.addEventListener('click', function() {
			this.classList.toggle('selected');
		});
	}
});
