<?php
CheckIfPageReloaded();
SessionAdd();
SessionChange();
BeginForm();
if($_SESSION['workoutStart'] == false) {
	ParagraphBYW();
	ImagesBYW();
} elseif($_SESSION['workoutGeslacht'] == '') {
	QuestionGeslacht();
} elseif(empty($_SESSION['workoutDoel'])) {
	QuestionDoel();
} elseif(empty($_SESSION['workoutSpier'])) {
	QuestionSpier();
} elseif($_SESSION['workoutAantal' ]== '') {
	QuestionAantal();
} else {
	ShowInfo();
}
EndForm();
AddJS();
?>