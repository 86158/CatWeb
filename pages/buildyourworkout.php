<?php
CheckIfPageReloaded();
SessionAdd();
SessionChange();
BeginForm();
if($_SESSION['workoutStart'] == false){
    ParagraphBYW();
    ImagesBYW();
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
    CompleteForm();
}
EndForm();
foreach($_SESSION['workoutSpier'] as $test){
    echo $test;
}
CompleteForm();
AddJS();
?>