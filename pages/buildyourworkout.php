<?php
CheckIfPageReloaded();
SessionAdd();
SessionChange();
BeginForm();
if($_SESSION['workoutStart'] == false){
    ParagraphBYW();
}
else if($_SESSION['workoutGeslacht'] == ''){
    QuestionGeslacht();
}
else if(empty($_SESSION['workoutDoel'])){
    QuestionDoel();
}
else if(empty($_SESSION['workoutSpier'])){
    QuestionSpier();
}
else if($_SESSION['workoutAantal' ]== ''){
    QuestionAantal();
}
else{
    echo 'Succes';
}
EndForm();
AddJS();
?>